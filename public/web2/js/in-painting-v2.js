const fileInput = document.querySelector("#ipFilePicker");
const fileInput2 = document.querySelector("#ipFilePicker2");
const inPaintStageContainer = document.querySelector('#inpainting-stag-outer');
const virtualStagDesignContainer = document.querySelector('#all_data0');
const modeValue = document.querySelector('#modeValueForPage');
const maskingCheckbox = document.getElementById('maskingCheckbox');
const cursorCheckbox = document.getElementById('cursorCheckbox');
const cursorCircle = document.createElement('div');
var routeFailedRespURL = document.getElementById('routeToGetFailedResp').getAttribute('data-route');
var runpodName = 'first_runpod';
var runpodType = '2' ;
var inpaintPodRoute = $("#routeToRunpodType").data('route');
// const generateDesignBtn = document.querySelector('#generateDesignBtn');
// const promptInput = document.querySelector('#promptInput');
// const promptInputDesign = document.querySelector('#promptInputDesign');
// const promptInputRoomType = document.querySelector('#promptInputRoomType');

const $imgCropPreview = $('#imgCropPreview');
let imageCropper;
var ids = []
let cursorBrushActions = []; // Keep track of cursor brush actions
let cursorBrushTempActions = []; // Keep track of cursor brush actions
let isCursorBrushing = false;
var hasTransparentPixels = false;
var segmentation = false;
var brushingActions = [];
var currentActionIndex = -1;
var checkboxMaskingLabel = [];

$imgCropPreview.cropper({
    aspectRatio: 1 / 1,
    zoomable: false,
    dragMode: 'none',
    minCropBoxWidth: 512,
    minCropBoxHeight: 512,
    maxCropBoxWidth: 512,
    maxCropBoxHeight: 512,
});

imageCropper = $imgCropPreview.data('cropper');
var croppedImage = '';

async function loadImageCropper() {
    $('#uploading_instruction').modal('hide');
    hasTransparentPixels = false;
    const [file] = fileInput.files;
    var image = '';
    image = await toBase64(file);
    if (dataPage == 'aiObjectRemoval' || dataPage == 'segmentPage' || dataPage == 'change-colors-texture' || dataPage == 'inPaint' || dataPage == 'fillSpace' || dataPage == 'color_swap') {
        ipsValidateImage(file, () => {
            clearPaintingStag();
            loadImageToStage(image.result);
            croppedImage = image.result;
        }, (error) => {
            ipsFailOnValidImage(error, min_height_width = 512);
            fileInput.value = '';
        }, 512);
    }
    else if (dataPage == 'collage_to_render') {
        ipsValidateImage(file, () => {
            clearPaintingStag();
            loadCollageImageToStage(image.result);
            croppedImage = image.result;
            }, (error) => {
            ipsFailOnValidImage(error, min_height_width = 512);
            fileInput.value = '';
        }, 512);
    }
    else if( dataPage == 'sky-color' || dataPage == 'design_transfer' || dataPage == 'floor_editor'){
        ipsValidateImage(file, () => {
            clearNonMaskPaintingStag();
            loadImageToStage(image.result);
            croppedImage = image.result;
        }, (error) => {
            ipsFailOnValidImage(error, min_height_width = 512);
            fileInput.value = '';
        }, 512);
    } else {
        ipsValidateImage(file, () => {
            var img = new Image();
            img.src = image.result;
            img.onload = function () {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                var data = imageData.data;
                for (var i = 0; i < data.length; i += 4) {
                    if (data[i + 3] < 255) {
                        hasTransparentPixels = true;
                        break;
                    }
                }
                // Hide or show the zoom buttons based on transparency
                if (hasTransparentPixels) {
                    // Destroy the existing cropper instance
                    $imgCropPreview.cropper('destroy');

                    // Initialize a new cropper with updated options
                    $imgCropPreview.cropper({
                        aspectRatio: NaN, //1 / 1,
                        dragMode: 'none',
                        zoomable: hasTransparentPixels,
                        minCropBoxWidth: 1024,
                        minCropBoxHeight: 512,
                        maxCropBoxWidth: 1024,
                        maxCropBoxHeight: 512,
                    });

                    // Get the new cropper instance
                    imageCropper = $imgCropPreview.data('cropper');

                    // Set zoomable option after initialization
                    $imgCropPreview.cropper('setZoomable', hasTransparentPixels);

                    // Replace the image and show modal
                    imageCropper.replace(image.result);
                    $("#cropImageModal").modal('show');
                    $('.upload_btns_part').show();
                    $('#zoomInOutLabel').show();
                    $('#zoomInButton').show();
                    $('#zoomOutButton').show();

                } else {
                    loadImageToStage(image.result);
                    croppedImage = image.result;
                    $('.upload_btns_part').hide();
                    $('#zoomInButton').hide();
                    $('#zoomOutButton').hide();
                    $('#zoomInOutLabel').hide();
                }
            }
        }, (error) => {
            ipsFailOnValidImage(error, min_height_width = 512);
            fileInput.value = '';
        }, 512);
    }
}

// Initialize the imageCropper variable
imageCropper = $imgCropPreview.data('cropper');

// Disable zoomable initially
$imgCropPreview.cropper('setZoomable', false);
var croppedImage = '';
async function cropImageButton() {
    if (hasTransparentPixels) {
        brushLayer.destroy();
        addBrushLayer();
    } else {
        brushLayer.destroyChildren();
        addBrushLayer();
    }
    croppedImage = imageCropper.getCroppedCanvas().toDataURL("image/png");
    if($('#myDecorCheckbox').prop("checked") == true) {
        // let getCanvasData = imageCropper.getCanvasData();
        // console.log(getCanvasData.width, getCanvasData.height);
        imageCropper.crop();
        croppedImage = imageCropper.getCroppedCanvas().toDataURL("image/png");
        imageCropper.clear();
    }

    await clearPaintingStag();
    loadImageToStage(croppedImage);
    $("#cropImageModal").modal('hide');
}

$("body").on('click', '.use-as-input-image', async function () {
    $('#loading_brilliance').modal('show');
    $('.redesign-designs-tabs').show();
    $('.top-menu-bar-third').hide();
    $('.category-container').hide();
    var routeURL = document.getElementById('routeToGetBase64Image').getAttribute('data-route');
    croppedImage = $(this).data('img');
    sec = $(this).data('sec');
    // $(".gs-option-flex li").removeClass("active");
    // $(".gs-option-flex li").eq(sec).addClass("active");
    if(dataPage == "collage_to_render"){
        loadCollageImageToStage(croppedImage);
        // document.getElementById('inpaint-stag').scrollIntoView();
        return;
    }
    if(dataPage == 'sky-color' || dataPage == 'design_transfer' || dataPage == 'floor_editor'){
        await clearNonMaskPaintingStag();
    }
    else{
        hasTransparentPixels = false;
        brushLayer.destroyChildren();
        addBrushLayer();
        await clearPaintingStag();
    }
    $.ajax({
        type: 'POST',
        url: routeURL,
        data: { imageURL: croppedImage },
        success: function (response) {
            croppedImage = 'data:image/png;base64,' + response.b64image;
            loadImageToStage(croppedImage);
        },
        error: function (error) {
            console.error('AJAX request failed', error);
        }
    });
    document.getElementById('inpaint-stag').scrollIntoView();
});

const sizeElement = document.querySelector("#ip-brush-thickness");
let size = sizeElement ? sizeElement.value : "";

var paintingStagOriginalWidth = inPaintStageContainer.clientWidth;
var paintingStagOriginalHeight = inPaintStageContainer.clientHeight;
var imageOriginalHeight;
var imageOriginalWidth;
var scaleX;
var scaleY;
var scale;
var sizes
var isBrushing = false;
let pixelRatio = 1;
let mode = 'brush';
var lastLine;

var resizeImageWidth;
var resizeImageHeight;

function calculateDynamicImageSize(width, height){
    if (width === height) {
        resizeImageWidth = 768
        resizeImageHeight = 768
    } else {
        if (width > height) {
            let newHeight = 768
            let ratio = width / height;
            let newWidth = Math.round(ratio * newHeight);
            resizeImageWidth = newWidth
            resizeImageHeight = newHeight
        } else if (height > width) {
            let newWidth = 768
            let ratio = height / width;
            let newHeight = Math.round(ratio * newWidth);
            resizeImageWidth = newWidth
            resizeImageHeight = newHeight
        }
    }
    return {resizeImageWidth,resizeImageHeight}
}


var lastLin, imageLayer, brushLayer, blackLayer, imageLayerSec, blackLayerSec;
const paintingStag = new Konva.Stage({
    container: 'painting-stag',
    width: paintingStagOriginalWidth,
    height: paintingStagOriginalHeight,
});

const paintingCollageStag = new fabric.Canvas(document.getElementById("collage-render-conva"));
let paintingStagSec;
const paintingStagSecElement = document.getElementById('painting-stag-sec');
if (paintingStagSecElement) {
    paintingStagSec = new Konva.Stage({
        container: 'painting-stag-sec',
        width: 0,
        height: 0,
    });
}

// generateDesignBtn.addEventListener('click', (e) => {
//     e.preventDefault();
//
// });
async function _generateInPaintingDesign(sec, el) {
    await callInPaintingAPI(sec,el);
}

function getImageCache(cacheid, callback){
    $.ajax({
        type: 'GET',
        url: "/image/cache",
        data: { 'id': cacheid, 'removeCache': true },
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
        },
        success: function (response) {
            callback(response);
        },
        error: function (error){
            callback(error);
        }
    });
}

function GetParameterValues(param) {
    var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < url.length; i++) {
        var urlparam = url[i].split('=');
        if (urlparam[0] == param) {
            return urlparam[1];
        }
    }
}

$('document').ready(function () {
    addImageLayer();
    addBlackLayer();
    addBrushLayer();

    if(dataPage == 'style_transfer' || dataPage == 'color_swap' || dataPage == 'design_transfer' || dataPage == 'floor_editor'){
        addSecImageLayer();
        addSecBlackLayer();

        fileInput2.addEventListener("change", async (e) => {
            loadImageCropperForStyleTransfer();
            e.target.value = '';
        });
    }

    $("#ip-clearImage, #ip-undoImage, #ip-redoImage").prop('disabled', true);
    $("#ip-clearImage, #ip-undoImage, #ip-redoImage").css('cursor', 'not-allowed');

    // var b64image = sessionStorage.getItem('b64image');

    // if (b64image) {
    //     loadImageBase64FromRedesign(b64image);
    // }

    var url = window.location.href;
    if(url.indexOf('?imageCacheId=') != -1){
        getImageCache(GetParameterValues('imageCacheId'), function(response, error){
            if(response.success){
                // Redirect to the 'precision+' route
                loadImageBase64FromRedesign(response.data);
            }
        });
    }
    else if(url.indexOf('&imageCacheId=') != -1){
        return true;
    }

    var fillspaceb64image = sessionStorage.getItem('fillspaceb64image');
    if (fillspaceb64image) {
        loadImageBase64FromFurnitureRemoval(fillspaceb64image);
    }

    fileInput.addEventListener("change", async (e) => {
        loadImageCropper();
        e.target.value = '';
    });

    $(".gs-select-range").slider({
        //   orientation: "vertical",
        range: "min",
        min: 0,
        max: 70,
        value: 70,
        slide: function (event, ui) {
            $("#amount").val(ui.value);
            $("#ip-brush-thickness").val(ui.value);
            size = ui.value;
        }
    });

    $("#inUploadBtn").on('click', function () {
        $("#ipFilePicker").trigger('click');
    });
    $("#inUploadBtn2").on('click', function () {
        $("#ipFilePicker2").trigger('click');
    });
    $("#inUploadBtnOnModal").on('click', function () {
        $("#ipFilePicker").trigger('click');
    });

    $("#ip-clearImage").on('click', function () {
        $('#removeMasking').addClass('disabled');
        $('#removeMasking').css('cursor', 'not-allowed');
        $('#addMasking').addClass('active');
        $('#removeMasking').removeClass('active');
        maskingCheckbox.value = true;
        $('.chkbox-segment ul li').removeClass('active');
        $('.checkbox').prop('checked', false);
        ids = [];
        cursorBrushActions = [];
        cursorBrushTempActions = [];

        brushLayer.destroyChildren();
        brushingActions = [];
        currentActionIndex = -1;
        brushLayer.draw();

        $("#ip-clearImage, #ip-undoImage, #ip-redoImage").prop('disabled', true);
        $("#ip-clearImage, #ip-undoImage, #ip-redoImage").css('cursor', 'not-allowed');
    });

    $("#ip-undoImage").on('click', function () {
        undoBrushing();
    });

    $("#ip-redoImage").on('click', function () {
        redoBrushing();
    });

    $('#removeMasking').addClass('disabled');
    $('#removeMasking').css('cursor', 'not-allowed');
});

function addImageLayer() {
    imageLayer = new Konva.Layer();
    paintingStag.add(imageLayer);
}
function addSecImageLayer() {
    imageLayerSec = new Konva.Layer();
    paintingStagSec.add(imageLayerSec);
}
var lastLine;
function addBrushLayer() {
    if (hasTransparentPixels || dataPage == 'sky-color' || dataPage == 'design_transfer' || dataPage == 'floor_editor') {
        // paintingStag.container().style.cursor = 'auto';
        return;
    }
    brushLayer = new Konva.Layer();
    paintingStag.add(brushLayer);

    // Add cursor styling
    paintingStag.container().style.cursor = 'none'; // Hide default cursor
    // Create a circle cursor element
    cursorCircle.id = 'cursorCircle';
    cursorCircle.style.position = 'absolute';
    cursorCircle.style.border = '1px  solid rgb(245, 244, 248)';
    cursorCircle.style.pointerEvents = 'none';
    cursorCircle.style.display = 'none'; // Hide initially
    cursorCircle.style.borderRadius = '50%';

    if (cursorCheckbox && cursorCheckbox.value === 'true') {
        cursorCircle.style.borderRadius = '0%';
    }
    // Append the circle cursor to the container
    paintingStag.container().appendChild(cursorCircle);

    let isInside = false; // Flag to track if cursor is inside the masking area

    // Update cursor visibility and position on mouse move
    paintingStag.on('mousemove touchmove', function (e) {
        const pos = paintingStag.getPointerPosition();
        if (isInside) {
            cursorCircle.style.display = 'block'; // Show the cursor
            cursorCircle.style.left = pos.x - size / 2 + 'px';
            cursorCircle.style.top = pos.y - size / 2 + 'px';
            cursorCircle.style.width = size + 'px';
            cursorCircle.style.height = size + 'px';
            cursorCircle.style.border = maskingCheckbox.value === 'true' ? '1px solid rgb(245, 244, 248)' : '1px solid rgb(199, 20, 20)';
        } else {
            cursorCircle.style.display = 'none'; // Hide the cursor
        }

        if (!isBrushing) {
            return;
        }
        e.evt.preventDefault();
        if (maskingCheckbox.value === 'true' && isBrushing) {
            var newPoints = lastLine.points().concat([pos.x, pos.y]);
            lastLine.points(newPoints);
        }

        if (maskingCheckbox.value === 'false' && isBrushing) {
            var newPoints = removalLine.points().concat([pos.x, pos.y]);
            removalLine.points(newPoints);
        }
        brushLayer.batchDraw();
    });

    // Brushing functionality
    let isBrushing = false;
    let lastLine = null;
    let removalLine = null;
    paintingStag.off('mousedown touchstart');
    paintingStag.on('mousedown touchstart', function (e) {
        if (!imageLayer.hasChildren()) {
            return;
        }

        const pos = paintingStag.getPointerPosition();
        isBrushing = true;
        if (maskingCheckbox.value === 'true') {
            // In masking mode
            if(cursorCheckbox.value === 'true'){
                lastLine = new Konva.Line({
                    stroke: '#FFFFFF',
                    strokeWidth: size,
                    globalCompositeOperation: 'xor', //source-over
                    lineCap: 'square',
                    lineJoin: 'square',
                    points: [pos.x, pos.y, pos.x, pos.y],
                    opacity: 0.5,
                });
            }else{
                lastLine = new Konva.Line({
                    stroke: '#FFFFFF',
                    strokeWidth: size,
                    globalCompositeOperation: 'xor', //source-over
                    lineCap: 'round',
                    lineJoin: 'round',
                    points: [pos.x, pos.y, pos.x, pos.y],
                    opacity: 0.5,
                });
            }
            brushLayer.add(lastLine);
            brushLayer.draw();
            addCursorBrushAction(lastLine);
            if (!hasTransparentPixels) {
                addBrushingAction(lastLine);
            }
            $('#removeMasking').removeClass('disabled');
            $('#removeMasking').css('cursor', 'pointer');
            maskingCheckbox.disabled = false;
        } else {
            // In remove masking mode
            if(cursorCheckbox.value === 'true'){
                removalLine = new Konva.Line({
                    points: [pos.x, pos.y, pos.x, pos.y],
                    lineCap: 'square',
                    lineJoin: 'square',
                    stroke: 'black', // Use the background color or image fill
                    strokeWidth: size, // Adjust based on your requirement
                    globalCompositeOperation: 'destination-out', // Clear the existing content
                });
            }else{
                removalLine = new Konva.Line({
                    points: [pos.x, pos.y, pos.x, pos.y],
                    lineCap: 'round',
                    lineJoin: 'round',
                    stroke: 'black', // Use the background color or image fill
                    strokeWidth: size, // Adjust based on your requirement
                    globalCompositeOperation: 'destination-out', // Clear the existing content
                });
            }

            brushLayer.add(removalLine);
            brushLayer.draw();
            if (!hasTransparentPixels) {
                addBrushingAction(removalLine);
            }
        }
    });

    paintingStag.on('mouseup touchend', function () {
        isBrushing = false;
        lastLine = null;
        removalLine = null;
    });

    // Set isInside flag to true when mouse enters the masking area
    paintingStag.on('mouseenter', function (e) {
        isInside = true;
    });

    // Set isInside flag to false when mouse leaves the masking area
    paintingStag.on('mouseleave', function (e) {
        isInside = false;
        isBrushing = false; // Stop brushing when mouse leaves
        cursorCircle.style.display = 'none'; // Hide the cursor when leaving the masking area
    });
}

function addBlackLayer() {
    blackLayer = new Konva.Layer({
        visible: false
    });
    paintingStag.add(blackLayer);
}

function addSecBlackLayer() {
    blackLayerSec = new Konva.Layer({
        visible: false
    });
    paintingStagSec.add(blackLayerSec);
}

// Function to add cursor brush action
function addCursorBrushAction(action) {
    cursorBrushActions.push(action);
    cursorBrushTempActions.push(action);
}

// Function to toggle brushing visibility
function toggleBrushingVisibility(visible) {
    brushLayer.visible(visible);
    brushLayer.batchDraw();
}

function clearPaintingStag() {
    brushLayer.destroyChildren();
    imageLayer.destroyChildren();
    blackLayer.destroyChildren();
    pixelRatio = 1;
    setStagW(paintingStag, paintingStagOriginalHeight);
    setStagH(paintingStag, paintingStagOriginalHeight);
}

function clearNonMaskPaintingStag(){
    imageLayer.destroyChildren();
    pixelRatio = 1;
    setStagW(paintingStag, paintingStagOriginalHeight);
    setStagH(paintingStag, paintingStagOriginalHeight);
}

function setStagW(stage, width) {
    stage.width(width);
}

function setStagH(stage, height) {
    stage.height(height);
}

function loadImageToStage(image) {
    $('.chkbox-segment').empty();
    $('.decor_img').removeClass('decor_hide_placehold');
    $('.decor_img').addClass('decor_show_placehold');
    $('.decor_placehold').removeClass('decor_show_placehold');
    $('.decor_placehold').addClass('decor_hide_placehold');
    if(maskingCheckbox){
        maskingCheckbox.value = true;
        $('#removeMasking').addClass('disabled');
        $('#removeMasking').css('cursor', 'not-allowed');
    }

    $("#ip-clearImage").click();

    const imageObj = new Image();
    imageObj.onload = async function () {
        sizes = calculateImageSize(imageObj.width, imageObj.height)
        setStagW(paintingStag, sizes.width);
        setStagH(paintingStag, sizes.height);
        // scaleX = 600 / imageObj.width;
        // scaleY = 600 / imageObj.height

        // Add image to painting stag
        var konvaImage = new Konva.Image({
            x: 0,
            y: 0,
            image: imageObj,
            scaleX: scale,
            scaleY: scale,
        });
        imageLayer.add(konvaImage);

        // Add black rect to layer
        var rect = new Konva.Rect({
            x: 0,
            y: 0,
            width: sizes.width,
            height: sizes.height,
            fill: 'black',
            strokeWidth: 0,
        });
        blackLayer.add(rect);
        if (!hasTransparentPixels && dataPage != 'aiObjectRemoval' && dataPage != 'sky-color' && dataPage != 'collage_to_render' && dataPage != 'design_transfer' && dataPage != 'floor_editor') {
            $('#loading_brilliance').modal('show');
            getNpyImgFile(image);
        }
    };
    imageObj.src = image;
    imageLayer.draw();
    blackLayer.draw();

    setTimeout(function () {
        $('.gs-modal-uploading_instruction_slider')[0].slick.refresh();
    }, 250);
    // setTimeout(function () {
        $('.top-menu-bar-first').css('display', 'none');
        $('.upload-image-container').css('display', 'none');
        $('.searched_product_result').css('display', 'none');
        $('.top-menu-bar-second').css('display', 'flex');
        $('.image-mask-container').css('display', 'block');
        $('.segment-masking-container').css('display', 'block');
        if (dataPage == 'redesign' || dataPage == 'productSearch' || dataPage == 'sky-color' || dataPage == 'rostMyHome' || dataPage == 'aiObjectRemoval' || dataPage == 'design_transfer' || dataPage == 'floor_editor') {
            $('.redesign-designs-tabs').css('display', 'none');
            $("#loading_brilliance").modal('hide');
        }
    // }, 2000)
}


function toBase64(field) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.addEventListener("load", () => {
            resolve(reader);
        });
        reader.readAsDataURL(field);
    });
}

function calculateImageSize(width, height) {
    var stageAspectRatio = paintingStagOriginalWidth / paintingStagOriginalHeight;
    var imageAspectRatio = width / height;

    if (width <= paintingStagOriginalWidth && height <= paintingStagOriginalHeight) {
        return {
            width,
            height
        };
    }

    if (imageAspectRatio < stageAspectRatio) {
        rHeight = paintingStagOriginalHeight;
        rWidth = width * (rHeight / height);

        scale = rWidth / width;
        pixelRatio = width / rWidth;

    } else if (imageAspectRatio > stageAspectRatio) {
        rWidth = paintingStagOriginalWidth
        rHeight = height * (rWidth / width);

        scale = rHeight / height;
        pixelRatio = height / rHeight;

    } else {
        rWidth = paintingStagOriginalWidth;
        rHeight = paintingStagOriginalHeight;
    }

    return {
        width: Math.round(rWidth),
        height: Math.round(rHeight)
    };

}


async function getMaskedImages() {
    blackLayer.visible(true);
    var dataURL = paintingStag.toDataURL({
        pixelRatio: pixelRatio
    });
    blackLayer.visible(false);

    return dataURL;
}

async function callInPaintingAPI(sec,el) {
    page = 1;
    getInPaintingGeneratedDesigns();
    const generateDesignBtn = el;
    const spinner = generateDesignBtn.querySelector('span#submit');
    const tabs = document.querySelectorAll('.gs-option-flex a');
    const previousPageButton = document.querySelector('.previous_page');

    disableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
    $('.on-gen-disable').addClass('disable-btn');
    // $('.full_hd_quality').addClass('disable-btn');
    // $('.edit-as-fill-space').addClass('disable-btn');
    // $('.precision-ultra-enhancer').addClass('disable-btn');
    // projectButton.disabled = true;
    // deleteButton.disabled = true;

    var mode = modeValue.value;
    var noOfDesign = document.getElementById(`no_of_des${sec}`).value;
    generationDivLoader(noOfDesign,croppedImage);
    $('.ai-upload-latest-designs')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    if (!imageLayer.hasChildren()) {
        alert('Upload image');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        $('.on-gen-disable').removeClass('disable-btn');
        removeLoaderDivs(noOfDesign);
        return;
    }
    if (!hasTransparentPixels && dataPage != 'sky-color' && dataPage != 'design_transfer') {
        if (!brushLayer.hasChildren()) {
            let error_message = 'Ensure your image is masked before submitting!';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
            $('.on-gen-disable').removeClass('disable-btn');
            removeLoaderDivs(noOfDesign);
            return;
        }
    }

    // var original_base64 = imageCropper.getCroppedCanvas().toDataURL("image/png");
    var original_base64 = croppedImage;
    var masked_base64 = await getMaskedImages();

    var superenhance = 0;
    var isSubbed = false;
    var is_staging = (APP_LOCAL == 'production') ? 'false' : 'true';

    var segmentType = segmentation ? segmentation : 'false';
    const promptInput = document.querySelector(`#custom_instruction${sec}`);
    const promptInputDesign = document.querySelector(`#selectedDesignStyle${sec}`);
    const promptInputRoomType = document.querySelector(`#selectedRoomType${sec}`);
    const promptSkyWeather = document.querySelector(`#weather${sec}`);

    const prompColorTexture = document.querySelector(`#color_texture${sec}`);
    const prompMaterialTypeTexture = document.querySelector(`#material_type${sec}`);
    const prompMaterialTexture = document.querySelector(`#material${sec}`);

    var prompt = promptInput ? promptInput.value : "";
    var designStyle = promptInputDesign ? promptInputDesign.value : "" ;
    var roomType = promptInputRoomType ? promptInputRoomType.value : "" ;
    var isTransparent = hasTransparentPixels;

    if (roomType == '' && dataPage!= 'aiObjectRemoval' && dataPage!= 'sky-color' && dataPage != 'change-colors-texture') {
        let error_message
        if(sec == 0){
            error_message = 'Make sure to select Room Type!';
        }else if(sec == 1){
            error_message = 'Make sure to select House Angle!';
        }else {
            error_message = 'Make sure to select Garden Type!';
        }
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        removeLoaderDivs(noOfDesign);
        $('.on-gen-disable').removeClass('disable-btn');
        return;
    }

    if (designStyle == '' && dataPage != 'aiObjectRemoval' && dataPage!= 'sky-color' && dataPage != 'change-colors-texture') {
        let error_message = 'Make sure to select Design Style!';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        $(el).attr('disabled', false);
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        removeLoaderDivs(noOfDesign);
        $('.on-gen-disable').removeClass('disable-btn');
        return;
    }

    var checkboxMaskingLabelString = checkboxMaskingLabel.join(', ');
    var color = prompColorTexture ? prompColorTexture.value : "";
    var material = prompMaterialTexture ? prompMaterialTexture.value : "" ;
    var material_type = prompMaterialTypeTexture ? prompMaterialTypeTexture.value : "" ;
    var skyWeather = promptSkyWeather ? promptSkyWeather.value : "" ;

    if (dataPage == 'sky-color' && skyWeather == '') {
        let error_message = 'Make sure to select Sky Color!';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        $(el).attr('disabled', false);
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        removeLoaderDivs(noOfDesign);
        $('.on-gen-disable').removeClass('disable-btn');
        return;
    }

    if (dataPage == 'change-colors-texture' && color == "" && (prompt == '' ||  $(`#custom_instruction${sec}`).prop('disabled'))){
        if (dataPage == 'change-colors-texture' && prompt == ''  && color == '' && material_type == '' && material == "") {
            let error_message = 'Please select Color or material type or write a prompt!';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            $(el).attr('disabled', false);
            enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
            removeLoaderDivs(noOfDesign);
            $('.on-gen-disable').removeClass('disable-btn');
            return;
        }
        if (dataPage == 'change-colors-texture' && material && material_type == '') {
            let error_message = 'Please select material type!';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            $(el).attr('disabled', false);
            enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
            removeLoaderDivs(noOfDesign);
            $('.on-gen-disable').removeClass('disable-btn');
            return;
        }
    }

    if(color != "" || material_type != ""){
        prompt = "";
    }
    var formData = new FormData();
    // var precisionUserValue = document.getElementById('precisionUser').value;
    if (dataPage == 'aiObjectRemoval' || dataPage == 'segmentPage') {
        // var inPaintUrl = `${GPU_SERVER_HOST}/img2img?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&modeType=${mode}&is_staging=${is_staging}&segmentType=${segmentType}`;
        var inPaintUrl = "/runpod/furniture_removal";
        formData.append("designtype", sec);
        // formData.append("isSubbed", isSubbed);
        // formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        // formData.append("designtype", sec);
        formData.append("modeType", mode);
        // formData.append("is_transparent", isTransparent);
        // formData.append("is_staging", is_staging);
        formData.append("segmentType", segmentType);
    } else if (dataPage == 'change-colors-texture') {
        // var inPaintUrl = `${GPU_SERVER_HOST_SEG}/change_color?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&modeType=${mode}&is_transparent=${isTransparent}&is_staging=${is_staging}&segmentType=${segmentType}&objects=${checkboxMaskingLabelString}&color=${color}&material=${material_type}`;
        var inPaintUrl = "/runpod/color-and-texture";
        // formData.append("isSubbed", isSubbed);
        // formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        // formData.append("is_transparent", isTransparent);
        // formData.append("is_staging", is_staging);
        formData.append("segmentType", segmentType);
        formData.append("objects", checkboxMaskingLabelString);
        formData.append("color", color);
        formData.append("material", material_type);
        // Need to add material_type and material
    } else if (dataPage == 'sky-color') {
        // var inPaintUrl = `${GPU_SERVER_HOST_SEG}/sky_color_change?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&is_staging=${is_staging}&weather=${skyWeather}&modeType=${mode}`;
        var inPaintUrl = "/runpod/sky-color-change";
        // formData.append("isSubbed", isSubbed);
        // formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        // formData.append("is_staging", is_staging);
        formData.append("weather", skyWeather);
    } else if (dataPage == 'decorstaging') {
        // var inPaintUrl = `${GPU_SERVER_HOST_SEG}/sky_color_change?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&is_staging=${is_staging}&weather=${skyWeather}&modeType=${mode}`;
        var inPaintUrl = "/runpod/decor_staging";
        // formData.append("isSubbed", isSubbed);
        formData.append("roomtype", roomType);
        formData.append("design_style", designStyle);
        // formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        formData.append("is_transparent", isTransparent);
        // formData.append("is_staging", is_staging);
        formData.append("segmentType", segmentType);
    } else if (dataPage == 'fillSpace' || dataPage == 'inPaint') {
        // var inPaintUrl = `${GPU_SERVER_HOST_SEG}/sky_color_change?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&is_staging=${is_staging}&weather=${skyWeather}&modeType=${mode}`;
        if(dataPage == 'inPaint'){
            var inPaintUrl = "/runpod/precision";
        }else if(dataPage == 'fillSpace'){
            var inPaintUrl = "/runpod/fill_space";
        }
        // formData.append("isSubbed", isSubbed);
        formData.append("roomtype", roomType);
        formData.append("design_style", designStyle);
        // formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        // formData.append("is_transparent", isTransparent);
        // formData.append("is_staging", is_staging);
        formData.append("segmentType", segmentType);
    }
    var payload = {
        // "fireid": user.uid,
        "init_images": original_base64,
        "mask": masked_base64,
        "prompt": prompt,
    };

    formData.append("payload", JSON.stringify(payload));
    return await fetch(inPaintUrl, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: "include",
        crossDomain: true,
        headers: {
            accept: 'multipart/form-data',
            'Access-Control-Allow-Origin': '*',
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
        },
        body: formData,
    }).then(response => {
        if (response.status === 200) {
            return response.text();
        }
        throw 'Server error';
    }).then(result => {
        console.log("result",result);

        var generatedImageList = ''
        var resultJsonFormat = JSON.parse(result);
        if(resultJsonFormat.status === false){
            $.ajax({
                url: routeFailedRespURL,
                type: 'post',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    "response": resultJsonFormat.response,
                    "payload": resultJsonFormat.payload,
                    "payloadData": resultJsonFormat.payloadData,
                    "prompt": resultJsonFormat.prompt,
                },
                success: function (result) {
                    generatedImageList = result['Sucess']['generated_image'];
                    console.log("generatedImageList",generatedImageList);

                    originalImage = result['Sucess']['original_image'];
                    let storedIds = result['storedIds'];
                    enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
                    removeLoaderDivs(noOfDesign);
                    $('.on-gen-disable').removeClass('disable-btn');
                    $('ai-upload-latest-designs').scrollIntoView();
                    // $('.full_hd_quality').removeClass('disable-btn');
                    // $('.edit-as-fill-space').removeClass('disable-btn');
                    // $('.precision-ultra-enhancer').removeClass('disable-btn');
                    projectButton.disabled = false;
                    // deleteButton.disabled = false;
                    // Iterate over the list of images
                    generatedImageList.forEach((image, index) => {
                        let design = {
                            id: storedIds[index],
                            original_url: originalImage,
                            generated_url: image,
                            style: designStyle,
                            room_type: roomType,
                            show_data: true,
                            section: sec,
                            hd_image: 0,
                        };
                        var itemHtml = generatedInPaintingItem(design);
                        // addNewDesignImage(design);
                        var data = document.getElementById(`all_data0`);
                        data.insertBefore(itemHtml, data.firstChild);
                    });
                    setTimeout(function () {
                        $('html, body').animate({
                            scrollTop: virtualStagDesignContainer.offsetTop
                        }, 100);
                    }, 500);
                },
                error: function (resp) {
                    swal("Something Went Wrong!", {
                        icon: "error",
                    });
                }
            });
        }else{
            generatedImageList = resultJsonFormat.Sucess.generated_image;
            console.log("generatedImageList",generatedImageList);
            originalImage = resultJsonFormat.Sucess.original_image;
            let storedIds = resultJsonFormat.storedIds;
            enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
            removeLoaderDivs(noOfDesign);
            $('.on-gen-disable').removeClass('disable-btn');
            generatedImageList.forEach((image, index) => {
                let design = {
                    id: storedIds[index],
                    original_url: originalImage,
                    generated_url: image,
                    style: designStyle,
                    room_type: roomType,
                    show_data: true,
                    section: sec,
                    hd_image: 0,
                };
                var itemHtml = generatedInPaintingItem(design);
                // addNewDesignImage(design);
                var data = document.getElementById(`all_data0`);
                data.insertBefore(itemHtml, data.firstChild);
            });
            setTimeout(function () {
                $('html, body').animate({
                    scrollTop: virtualStagDesignContainer.offsetTop
                }, 100);
            }, 500);
        }
    }).catch(error => {
        $('.on-gen-disable').removeClass('disable-btn');
        removeLoaderDivs(noOfDesign);
        // $('.full_hd_quality').removeClass('disable-btn');
        // $('.edit-as-fill-space').removeClass('disable-btn');
        // $('.precision-ultra-enhancer').removeClass('disable-btn');
        // projectButton.disabled = false;
        // deleteButton.disabled = false;
        console.log("Something went wrong. Please try again in some time.");
        // alert("Something went wrong. Please try again in some time.");
    });
}

function generatedImageItem(item) {
    var temp = document.getElementById("inPaintingCard");
    var clone = temp.content.cloneNode(true);
    var img = clone.querySelector('[data-item="image"]');
    var downloadBtn = clone.querySelector('[data-item="download-btn"]');
    var previewBtn = clone.querySelector('[data-item="preview-btn"]');
    var fullHdBtn = clone.querySelector('[data-item="hd_quality"]');
    var useAsInput = clone.querySelector('[data-item="user_as_input"]');
    var feedback_btn = clone.querySelector('.feedback_btn');
    var editAsFillSpace = clone.querySelector('[data-item="edit_as_fill_space"]');
    var checkbox = clone.querySelector('.ml_dw_img');
    var styleSpan = clone.querySelector('.render-overlay-box .render-overlay:nth-child(1)');
    var roomTypeSpan = clone.querySelector('.render-overlay-box .render-overlay:nth-child(2)');
    // var precision_enhance = clone.querySelector('.precision-ultra-enhancer');
    var hdImageDiv = clone.querySelector('.hd_image_div');

    var dynamicClass = "favoriteImage" + item.generated_image;
    var favImg = clone.querySelector('.favcheckimg');
    favImg.classList.add(dynamicClass);

    var dynamicParameter = item.generated_image;
    favImg.setAttribute('onclick', `addRemovefavorite('${dynamicParameter}')`);
    checkbox.setAttribute('onclick', `getMultipleImages('${dynamicParameter}')`);

    // downloadBtn.href = item.generated_image;
    downloadBtn.dataset.downloadUrl = item.generated_image;
    previewBtn.dataset.img = item.generated_image;
    fullHdBtn.dataset.img = item.generated_image;
    useAsInput.dataset.img = item.generated_image;
    feedback_btn.dataset.img = item.generated_image;
    // precision_enhance.dataset.img = item.generated_image;
    if (editAsFillSpace) {
        editAsFillSpace.dataset.img = item.generated_image;
    }
    img.src = item.generated_image;
    if (item.design_style !== undefined && item.design_style !== '' && item.design_style != 'N/A') {
        styleSpan.textContent = "Style: " + item.design_style;
    }
    if (item.room_type !== undefined && item.room_type !== '' && item.design_style != 'N/A') {
        roomTypeSpan.textContent = "Room Type: " + item.room_type;
    }

    if (item.hd_image === true) {
        hdImageDiv.style.display = 'block';
        fullHdBtn.style.display = 'none';
    } else {
        hdImageDiv.style.display = 'none';
        // fullHdBtn.style.display = 'block';
    }

    return clone;
}
$(document).on('click', '.full_hd_quality', async function () {
    page = 1;
    getInPaintingGeneratedDesigns();
    var sec = $(this).data('sec');
    $('.painting_generating_bt').addClass('disable-btn');
    $('.on-gen-disable').addClass('disable-btn');
    var image_url = $(this).data('img');
    var inputImage = $(this).data('input-img');
    // $('.full_hd_quality').addClass('disable-btn');
    // $('.edit-as-fill-space').addClass('disable-btn');
    // $('.precision-ultra-enhancer').addClass('disable-btn');
    projectButton.disabled = true;
    // deleteButton.disabled = true;

    // Disable AI category Pill
    _updateAiCatePillsStatus('disable');

    generationDivLoader(1,image_url);
    $('.ai-upload-latest-designs')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    document.getElementById(`jumphere0`).scrollIntoView();

    var divElement = document.getElementById(`all_data0`);
    divElement.firstElementChild.scrollIntoView();

    var mode = modeValue.value;
    $("#mip_before").attr('src', inputImage);
    $("#mip_after").attr('src', image_url);
    var route = $("#routeToFullHdImageData").data('route');
    var is_staging = (APP_LOCAL == 'production') ? 'false' : 'true';
    $.ajax({
        url: route,
        method: "POST",
        data: {
            "image": image_url
        },
        success: async function (resp) {
            if(resp.status == false ){
                $('.painting_generating_bt').removeClass('disable-btn');
                $('.on-gen-disable').removeClass('disable-btn');
                // $('.full_hd_quality').removeClass('disable-btn');
                // $('.edit-as-fill-space').removeClass('disable-btn');
                // $('.precision-ultra-enhancer').removeClass('disable-btn');
                projectButton.disabled = false;
                // deleteButton.disabled = false;
                removeLoaderDivs(1);
            }else{
                var formData = new FormData();
                formData.append("privateId", resp.data.privateId);
                formData.append("roomtype", resp.data.room_type);
                formData.append("design_style", resp.data.style);
                formData.append("modeType", mode);
                formData.append("is_staging", is_staging);
                formData.append("designtype", resp.data.sec);
                formData.append("data", resp.data.image);
                formData.append("runpod_name", runpodName);
                // aiAPI = `${GPU_SERVER_HOST}/fullhd?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&id=${resp.data.user_uid}&privateId=${resp.data.privateId}&is_staging=${is_staging}&roomtype=${resp.data.room_type}&design_style=${resp.data.style}&modeType=${mode}`;
                aiAPI = "/runpod/fullHD";
                await fetch(aiAPI, {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: "include",
                    headers: {
                        accept: 'multipart/form-data',
                        'Access-Control-Allow-Origin': '*',
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
                    },
                    crossDomain: true,
                    body: formData,
                })
                    .then(response => {
                        if (response.status == 501) {
                            modalStore.style.display = 'block';
                        }
                        return response.json();
                    })
                    .then(result => {
                        $('.on-gen-disable').removeClass('disable-btn');
                        $('.painting_generating_bt').removeClass('disable-btn');
                        // $('.full_hd_quality').removeClass('disable-btn');
                        // $('.edit-as-fill-space').removeClass('disable-btn');
                        // $('.precision-ultra-enhancer').removeClass('disable-btn');
                        // projectButton.disabled = false;
                        // deleteButton.disabled = false;
                        var generated_image = result['Sucess']['generated_image'][0];
                        var original_image = result['Sucess']['original_image'];
                        let storedIds = result['storedIds'];
                        // var data = document.getElementById(`all_data${sec}`);
                        // var newFreeformSpacer = document.createElement('div');
                        // data.insertBefore(newFreeformSpacer, data.firstChild);

                        var design = {
                            id: storedIds[0],
                            original_url: original_image,
                            generated_url: generated_image,
                            style: resp.data.style,
                            room_type: resp.data.room_type,
                            mode: resp.data.mode,
                            show_data: true,
                            section: sec,
                            private: resp.data.privateId,
                            // precisionUserValue: precisionUserValue,
                            hd_image: 1,
                        }
                        removeLoaderDivs(1);
                        var itemHtml = generatedInPaintingItem(design);
                        // addNewDesignImage(design);

                        var data = document.getElementById(`all_data0`);
                        data.insertBefore(itemHtml, data.firstChild);
                        // Enable AI category Pill
                        _updateAiCatePillsStatus('enable');
                    })
                    .catch(error => {
                        $('.on-gen-disable').removeClass('disable-btn');
                        $('.painting_generating_bt').removeClass('disable-btn');
                        removeLoaderDivs(1);
                        // $('.full_hd_quality').removeClass('disable-btn');
                        // $('.edit-as-fill-space').removeClass('disable-btn');
                        // $('.precision-ultra-enhancer').removeClass('disable-btn');
                        projectButton.disabled = false;
                        // deleteButton.disabled = false;

                        console.error('Error:', error);
                    });
            }
        },
        error: function (resp) {
            data = resp.responseJSON;
        }
    })
});

function closeCustomModal(modal) {
    $("#modalImagePreview").show();
}
let get_inpainting_designs = {
    url: SITE_BASE_URL + 'in-painting-designs',
    inpainting: modeValue.value,
}

var page = 1;
$(document).on('click', '.new-page-link', function () {
    page = $(this).attr('data-url').split('=').pop();
    getInPaintingGeneratedDesigns();
});

function getInPaintingGeneratedDesigns() {
    var response = null;
    // let paintingDesignUrl = $('#getInPaintingDesigns').data('url');
    $.ajax({
        url: get_inpainting_designs.url,
        data: {
            inpainting: get_inpainting_designs.inpainting,
            page: page,
            designType : get_inpainting_designs.design_type,
        },
        async: false,
        beforeSend: function () {

        },
        success: function (resp) {
            $('#all_data0').html('');
            $('#all_data0').html(resp.data);
        },
        error: function (error) { },
        complete: function () {

        }
    });
    return response;
}
var cropperActive = true;
var myDecorCheckbox = document.getElementById('myDecorCheckbox');
if (myDecorCheckbox) {
    $("#cropImageModal").on("show.bs.modal", function () {
        $("#myDecorCheckbox").prop("checked", false);
        cropperActive = true;
        $imgCropPreview.cropper('enable');
    });
    document.getElementById('myDecorCheckbox').addEventListener('change', function () {
        if (this.checked) {
            if (cropperActive) {
                $imgCropPreview.cropper('clear'); // Clear any existing crop
                // $imgCropPreview.cropper('disable');
                $imgCropPreview.cropper({
                    zoomable: true,
                });
                cropperActive = false;
            }
        } else {
            if (!cropperActive) {
                $imgCropPreview.cropper('enable'); // Enable the cropper tool
                $imgCropPreview.cropper('crop');  // Show the crop box manually
                cropperActive = true;
            }
        }
        if (hasTransparentPixels) {
            $('#zoomInButton').show();
            $('#zoomOutButton').show();
        }
    });
}
$('#zoomInButton').on('click', function () {
    imageCropper.zoom(0.1); // Increase zoom level by 10%
});

$('#zoomOutButton').on('click', function () {
    imageCropper.zoom(-0.1); // Decrease zoom level by 10%
});
function loadImageBase64FromRedesign(b64image) {
    croppedImage = b64image;
    sessionStorage.removeItem('b64image');

    if (dataPage === 'collage_to_render') {
        $('#loading_brilliance').modal('show');
        loadCollageImageToStage(b64image);
    } else {
        if (dataPage === 'sky-color' || dataPage == 'design_transfer' || dataPage == 'floor_editor') {
            clearNonMaskPaintingStag();
        } else {
            clearPaintingStag();
        }
        loadImageToStage(b64image);
    }
}

function addBrushingAction(action) {
    brushingActions = brushingActions.slice(0, currentActionIndex + 1);
    brushingActions.push(action);
    currentActionIndex = cursorBrushActions.length - 1;
    if(currentActionIndex >= 0){
        $("#ip-clearImage, #ip-undoImage").prop('disabled', false);
        $("#ip-clearImage, #ip-undoImage").css('cursor', 'pointer');
    }
}

function undoBrushing() {
    if (currentActionIndex >= 0) {
        const actionToRemove = cursorBrushTempActions[currentActionIndex];
        actionToRemove.remove(); // Assuming each action has a 'remove' method to undo it
        currentActionIndex--;

        // Find the index of actionToRemove in cursorBrushActions
        const indexToRemove = cursorBrushActions.indexOf(actionToRemove);

        // If the index is found, remove it from cursorBrushActions
        if (indexToRemove !== -1) {
            cursorBrushActions.splice(indexToRemove, 1);
        }

        $("#ip-redoImage").prop('disabled', false);
        $("#ip-redoImage").css('cursor', 'pointer');
        if (currentActionIndex === -1) {
            $("#ip-undoImage").prop('disabled', true);
            $("#ip-undoImage").css('cursor', 'not-allowed');
            if(ids.length == 0){
                $("#ip-clearImage").prop('disabled', true);
                $("#ip-clearImage").css('cursor', 'not-allowed');
            }
        }
    }
}

function redoBrushing() {
    if (currentActionIndex < cursorBrushTempActions.length - 1) {
        currentActionIndex++;
        const actionToRedo = cursorBrushTempActions[currentActionIndex];
        cursorBrushActions.push(actionToRedo);
        brushLayer.add(actionToRedo);

        $("#ip-undoImage").prop('disabled', false);
        $("#ip-undoImage").css('cursor', 'pointer');
        if(ids.length == 0){
            $("#ip-clearImage").prop('disabled', false);
            $("#ip-clearImage").css('cursor', 'pointer');
        }
        if (currentActionIndex === cursorBrushTempActions.length - 1) {
            $("#ip-redoImage").prop('disabled', true);
            $("#ip-redoImage").css('cursor', 'not-allowed');
        }
    }
}

async function getMaskImage() {
    if (!imageLayer.hasChildren()) {
        alert('Upload image');
        return;
    }
    if (!hasTransparentPixels) {
        if (!brushLayer.hasChildren()) {
            alert('Mask image.');
            return;
        }
    }

    const generateDesignBtn = document.querySelector(`.generateDesignBtn0`);

    generateDesignBtn.disabled = true;
    generateDesignBtn.getElementsByTagName('span')[0].style.display = 'inline-block';

    var original_base64 = croppedImage;
    var masked_base64 = await getMaskedImages();

    var originalDownloadLink = document.getElementById('downloadOriginalImageLink');
    originalDownloadLink.href = original_base64;
    originalDownloadLink.download = 'original_image.png';

    var maskDownloadLink = document.getElementById('downloadMaskImageLink');
    maskDownloadLink.href = masked_base64;
    maskDownloadLink.download = 'mask_image.png';

    originalDownloadLink.click();
    maskDownloadLink.click();

    setTimeout(function () {
        generateDesignBtn.disabled = false;
        generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
    }, 2000)

    $("#ip-clearImage").click();
}
var imageSrcNpy = '';
var segmentHeight = '';
var segmentWidth = '';
async function getNpyImgFile(img) {
    imageSrcNpy = img;
    var isSubbed = true;
    // var embededImgFile = `${GPU_SERVER_HOST_SEG}/get_masking?is_staging=${isSubbed}&id=${user.uid}&width=${sizes.width}&height=${sizes.height}`;
    var embededImgFile = `/runpod/getMasking?is_staging=${isSubbed}&width=${sizes.width}&height=${sizes.height}`;

    var formData = new FormData();

    formData.append("data", img);

    return await fetch(embededImgFile, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: "include",
        crossDomain: true,
        headers: {
            accept: 'multipart/form-data',
            'Access-Control-Allow-Origin': '*',
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')

        },
        body: formData,
    }).then(response => {
        if (response.status === 200) {
            hideLoader();
            return response.text();
        }
        throw 'Server error';
    }).then(result => {
        if (result.error) {
            alert(result.error);
            return;
        }
        result = JSON.parse(result);
        segmentationInfo = result.segments_info

        const segmentationValues = result.segmentation;

        segmentHeight = tf.tensor2d(segmentationValues).shape[0];
        segmentWidth = tf.tensor2d(segmentationValues).shape[1];

        var ulElement = $('<ul>',);

        segmentationInfo.forEach(function (result) {
            var label = result.label;
            var checkboxId = result.id;

            var liElement = $('<li>');
            var checkbox = $('<input>', { type: 'checkbox', id: checkboxId, name: 'checkbox', value: checkboxId, class: 'checkbox' }).hide();;
            var labelElement = $('<label>', { for: checkboxId, text: label });

            liElement.append(checkbox).append(labelElement);
            ulElement.append(liElement);
        });
        $('.chkbox-segment').append(ulElement);

        ulElement.on('click', 'li', function () {
            var checkbox = $(this).find('input[type="checkbox"]');
            var isChecked = checkbox.prop('checked');
            checkbox.prop('checked', !isChecked);
            $(this).toggleClass('active', !isChecked);

            var labelText = $(this).find('label').text();

            if (!isChecked) {
                ids.push(Number(checkbox.val()));
                checkboxMaskingLabel.push(labelText);
            } else {
                var indexToRemove = checkboxMaskingLabel.indexOf(labelText);
                if (indexToRemove !== -1) {
                    checkboxMaskingLabel.splice(indexToRemove, 1);
                }
                let valueToDelete = Number(checkbox.val());
                ids = ids.filter(item => item !== valueToDelete);
            }
            loadImage(ids, segmentationValues);
        });
        addBrushLayer();
    }).catch(error => {
        hideLoader(); // Hide loader in case of an error
        alert(error);
    });
}
async function loadImage(ids,segmentationValues) {
    // const imageObj = new Image();
    // imageObj.onload = async function () {
    //     var sizes = calculateDynamicImageSize(imageObj.width, imageObj.height);
    //     setStagW(paintingStag, sizes.resizeImageWidth);
    //     setStagH(paintingStag, sizes.resizeImageHeight);
    //     scaleX = sizes.resizeImageWidth / imageObj.width;
    //     scaleY = sizes.resizeImageHeight / imageObj.height

    //     // Add image to painting stag
    //     var konvaImage = new Konva.Image({
    //         x: 0,
    //         y: 0,
    //         image: imageObj,
    //         scaleX: scaleX,
    //         scaleY: scaleY,
    //     });
    //     imageLayer.add(konvaImage);

    //     // Add black rect to layer
    //     var rect = new Konva.Rect({
    //         x: 0,
    //         y: 0,
    //         width: sizes.resizeImageWidth,
    //         height: sizes.resizeImageHeight,
    //         fill: 'black',
    //         strokeWidth: 0,
    //     });
    //     blackLayer.add(rect);
    // };
    // imageObj.src = imageSrcNpy;
    // imageLayer.draw();
    // blackLayer.draw();
    await new Promise(resolve => setTimeout(resolve, 100));
    if (ids) {
        if(ids.length > 0){
            segmentation = true;
            $('#removeMasking').removeClass('disabled');
            $('#removeMasking').css('cursor', 'pointer');
            $("#ip-clearImage").prop('disabled', false);
            $("#ip-clearImage").css('cursor', 'pointer');
        }else{
            segmentation = false;
            $('#removeMasking').addClass('disabled');
            $('#removeMasking').css('cursor', 'not-allowed');
            maskingCheckbox.value = true;
            $('#addMasking').addClass('active');
            $('#removeMasking').removeClass('active');
            if (currentActionIndex > 0) {
                $('#ip-clearImage').prop('disabled', false).css('cursor', 'pointer');
            } else {
                $('#ip-clearImage').prop('disabled', true).css('cursor', 'not-allowed');
            }
        }
        await updateMask(ids,segmentationValues)
    }
    // return ctx
}

async function updateMask(ids,segmentationValues) {
    // Clear existing rectangles from imageLayer
    // imageLayer.destroyChildren();
    // Iterate through each segmentation value

    // Clear existing rectangles from imageLayer and brushLayer
    brushLayer.destroyChildren();
    ids.forEach((id)=> {
        const rectanglesArray = [];
        // Your existing code
        const mask = tf.equal(tf.tensor2d(segmentationValues), id);
        const colorSeg = tf.where(mask, tf.fill(mask.shape, 255), tf.zerosLike(mask));
        const colorSegArray = colorSeg.arraySync();
        // Create a new Konva.Rect to represent the masked area
        colorSegArray.forEach((row, i) => {
            let startCol = -1;
            row.forEach((color, j) => {
                if (color === 255) {
                    if (startCol === -1) {
                        startCol = j;
                    }
                } else if (startCol !== -1) {
                    // Create a Konva.Rect to represent the masked area for the batch of pixels
                    const x = startCol;
                    const y = i;
                    const width = j - startCol;
                    const height = 1;

                    const rect = new Konva.Rect({
                        x: x,
                        y: y,
                        width: width,
                        height: height,
                        fill: 'rgba(255, 255, 255, 0.5)',
                        strokeWidth: 0,
                    });
                    // Add the rect to the imageLayer
                    imageLayer.add(rect);
                    rectanglesArray.push(rect);
                    brushLayer.add(rect);
                    // Reset the startCol for the next batch
                    startCol = -1;
                }
            });
            addBrushingAction(rectanglesArray)
            // Handle the case where the last batch extends to the end of the row
            if (startCol !== -1) {
                const x = startCol;
                const y = i;
                const width = row.length - startCol;
                const height = 1;

                const rect = new Konva.Rect({
                    x: x,
                    y: y,
                    width: width,
                    height: height,
                    fill: 'rgba(255, 255, 255, 0.5)',
                    strokeWidth: 0,
                });

                // Add the rect to the imageLayer
                imageLayer.add(rect);
                brushLayer.add(rect);
                // addBrushingAction(rect)
            }
        });
    });
    // Redraw the imageLayer to reflect the changes
    imageLayer.batchDraw();
    brushLayer.batchDraw();
    // Add cursor brush actions
    cursorBrushActions.forEach(action => {
        brushLayer.add(action);
    });
}


function addKonvaListeners() {
    // Konva stage and layer initialization
    const stage = new Konva.Stage({
        container: 'canvas',
        width: segmentWidth,
        height: segmentHeight,
    });

    const layer = new Konva.Layer();
    stage.add(layer);

    // Konva click event
    stage.on('click', function (e) {
        const pos = stage.getPointerPosition();
        const color = ctx.getImageData(pos.x, pos.y, 1, 1).data;

        const id = getColorId(color);
        if (id !== null) {
            handleCheckbox(id);
        }
    });

    // Konva hover event
    stage.on('mouseover', function () {
        isHovering = true;
        layer.draw();
    });

    stage.on('mouseout', function () {
        isHovering = false;
        layer.draw();
    });

    layer.draw();
}


function _updateAiCatePillsStatus(status) {

    if (status == 'disable') {
        $("#ai-category-pills").find('button.nav-link:not(.active)').addClass('ai-pill-disabled').attr('disabled', true);
    } else {
        $("#ai-category-pills").find('button.nav-link:not(.active)').removeClass('ai-pill-disabled').attr('disabled', false);
    }
}

function showLoader() {
    $('.inpainting-stag-outer').css('filter', 'blur(5px)'); // Apply blur effect
    // $('.inpainting-stag-loader').show(); // Show loader
    $("#loadToStagLoader").modal('show');
    $("#loadToStagLoader").css('display', 'flex');
}

// Function to hide the loader
function hideLoader() {
    $("#loading_brilliance").modal('hide');
}

$(document).on('click', '.edit-as-fill-space', function () {
    if (user == null) {
        showLoginModal();
        return;
    }

    var precisionUserValue = document.getElementById('precisionUser').value;
    if(!precisionUserValue){
        $("#modalUpgradePlan").modal('show');
        return;
    }

    var img = $(this).data('img');
    var routeURL = document.getElementById('editAsFillSpace').getAttribute('data-route');

    $('.painting_generating_bt').addClass('disable-btn');
    $('.full_hd_quality').addClass('disable-btn');
    $('.edit-as-fill-space').addClass('disable-btn');
    $('.precision-ultra-enhancer').addClass('disable-btn');
    $.ajax({
        type: 'POST',
        url: routeURL,
        data: { imageURL: img },
        success: function (response) {
            if (response && response.b64image) {
                var b64image = 'data:image/png;base64,' + response.b64image;
                sessionStorage.setItem('fillspaceb64image', b64image);
                // Redirect to the 'precision+' route
                window.location.href = '/user/fill-spaces';
            }
        },
        error: function (error) {
            console.error('AJAX error:', error);
        }
    });
});

function loadImageBase64FromFurnitureRemoval(fillspaceb64image)
{
    clearPaintingStag();
    croppedImage = fillspaceb64image ;
    loadImageToStage(fillspaceb64image);
    sessionStorage.removeItem('fillspaceb64image');
}

function changeCursor(){
    if (cursorCheckbox.value === 'true') {
        cursorCircle.style.borderRadius = '0%';
    }
    else{
        cursorCircle.style.borderRadius = '50%';
    }
}

$(document).on('click', '.precision-ultra-enhancer', async function () {
    runpodType = '2' ;
    $.ajax({
        url: inpaintPodRoute,
        type: 'post',
        dataType: 'json',
        data: {
            "runpodType": runpodType
        },
        success: function (resp) {
            // Handle the response here, which contains the next runpod
            runpodName = resp.runpodName;
        },
        error: function (resp) {
            swal("Something Went Wrong!", {
                icon: "error",
            });
        }
    });



    $('.painting_generating_bt').addClass('disable-btn');
    $('.full_hd_quality').addClass('disable-btn');
    $('.edit-as-fill-space').addClass('disable-btn');
    $('.precision-ultra-enhancer').addClass('disable-btn');
    projectButton.disabled = true;
    // deleteButton.disabled = true;

    // Disable AI category Pill
    _updateAiCatePillsStatus('disable');

    var itemHtml = `
			<div class="snippet dot-in-paint-loader" data-title="dot-pulse">
                <div class="stage">
                    <div class="dot-pulse"></div>
                </div>
            </div>`;
    var loaderdata = document.getElementById('virtualStagDesignContainer');

    const newFreeformSpacer = document.createElement('div');
    newFreeformSpacer.className = 'col-sm-12 col-md-3';
    newFreeformSpacer.id = 'progressindicatordiv';

    const newDiv = document.createElement('div');
    newDiv.className = 'in-painting-card loader-card mb-3';

    loaderdata.insertBefore(newFreeformSpacer, loaderdata.firstElementChild);

    newDiv.innerHTML = itemHtml;
    newFreeformSpacer.appendChild(newDiv);

    var divElement = document.getElementById('virtualStagDesignContainer');
    divElement.firstElementChild.scrollIntoView();
    // newFreeformSpacer.innerHTML = itemHtml;

    // loaderdata.insertBefore(newFreeformSpacer, loaderdata.firstChild);

    var mode = modeValue.value;
    var image_url = $(this).data('img');
    $("#mip").attr('src', image_url);
    var route = $("#routeToFullHdImageData").data('route');
    var is_staging = (APP_LOCAL == 'production') ? 'false' : 'true';
    $.ajax({
        url: route,
        method: "POST",
        data: {
            "image": image_url
        },
        success: async function (resp) {
            if(resp.status == false ){
                $('.painting_generating_bt').removeClass('disable-btn');
                $('.full_hd_quality').removeClass('disable-btn');
                $('.edit-as-fill-space').removeClass('disable-btn');
                $('.precision-ultra-enhancer').removeClass('disable-btn');
                projectButton.disabled = false;
                // deleteButton.disabled = false;
                $("#progressindicatordiv").remove();
            }else{
                var strengthType = 'very_low';
                var styleType = 'No Style';
                var noOfDesign = '1' ;
                var formData = new FormData();
                formData.append("privateId", resp.data.privateId);
                formData.append("roomtype", resp.data.room_type);
                formData.append("design_style", resp.data.style);
                formData.append("modeType", mode);
                formData.append("is_staging", is_staging);
                formData.append("strengthType", strengthType);
                formData.append("no_of_Design", noOfDesign);
                formData.append("prompt", styleType);
                formData.append("designtype", resp.data.sec);
                formData.append("data", resp.data.image);
                formData.append("runpod_name", runpodName);
                formData.append("public", 0);
                // aiAPI = `${GPU_SERVER_HOST}/fullhd?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&id=${resp.data.user_uid}&privateId=${resp.data.privateId}&is_staging=${is_staging}&roomtype=${resp.data.room_type}&design_style=${resp.data.style}&modeType=${mode}`;
                aiAPI = "/runpod/precision_ehance";
                await fetch(aiAPI, {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: "include",
                    headers: {
                        accept: 'multipart/form-data',
                        'Access-Control-Allow-Origin': '*',
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
                    },
                    crossDomain: true,
                    body: formData,
                })
                    .then(response => {
                        if (response.status == 501) {
                            modalStore.style.display = 'block';
                        }
                        return response.json();
                    })
                    .then(result => {
                        $('.painting_generating_bt').removeClass('disable-btn');
                        $('.full_hd_quality').removeClass('disable-btn');
                        $('.edit-as-fill-space').removeClass('disable-btn');
                        $('.precision-ultra-enhancer').removeClass('disable-btn');
                        projectButton.disabled = false;
                        // deleteButton.disabled = false;
                        var image = result['Sucess']['generated_image'][0];
                        var design = {
                            generated_image : image,
                            design_style: resp.data.style,
                            room_type: resp.data.room_type,
                        }
                        var itemHtml = generatedImageItem(design);
                        var data = document.getElementById(`virtualStagDesignContainer`);
                        data.insertBefore(itemHtml, data.firstChild);
                        setTimeout(function () {
                            $('html, body').animate({
                                scrollTop: virtualStagDesignContainer.offsetTop
                            }, 100);
                        }, 500);
                        $("#progressindicatordiv").remove();
                        // Enable AI category Pill
                        _updateAiCatePillsStatus('enable');
                    })
                    .catch(error => {
                        $('.painting_generating_bt').removeClass('disable-btn');
                        $('.full_hd_quality').removeClass('disable-btn');
                        $('.edit-as-fill-space').removeClass('disable-btn');
                        $('.precision-ultra-enhancer').removeClass('disable-btn');
                        projectButton.disabled = false;
                        // deleteButton.disabled = false;

                        console.error('Error:', error);
                    });
            }
        },
        error: function (resp) {
            data = resp.responseJSON;
        }
    })
});

function generatedInPaintingItem(item){
    console.log("item",item);
    var temp = document.getElementById("inPaintingCard");
    var clone = temp.content.cloneNode(true);
    // var inputImg = clone.querySelector('[data-item="input-image"]');
    var outputImg = clone.querySelector('[data-item="output-image"]');
    // var downloadInputBtn = clone.querySelector('[data-item="download-input-btn"]');
    var downloadOutputBtn = clone.querySelector('[data-item="download-output-btn"]');
    // var previewInputBtn = clone.querySelector('[data-item="preview-btn-input"]');
    var previewOutputBtn = clone.querySelector('[data-item="preview-btn-output"]');
    var fullHdBtn = clone.querySelector('[data-item="hd_quality"]');
    // var useAsInputImage = clone.querySelector('[data-item="user_as_input_image"]');
    // var useAsOutputImage = clone.querySelector('[data-item="user_as_output_image"]');
    // var editImage = clone.querySelector('[data-item="edit_image"]');
    // var feedback_btn = clone.querySelector('.feedback_btn');
    // var editAsFillSpace = clone.querySelector('[data-item="edit_as_fill_space"]');
    // var checkbox = clone.querySelector('.ml_dw_img');
    var styleSpan = clone.querySelector('.render-overlay-data-box .render-overlay-data:nth-child(1)');
    var roomTypeSpan = clone.querySelector('.render-overlay-data-box .render-overlay-data:nth-child(2)');
    // var modeTypeSpan = clone.querySelector('.render-overlay-data-box .render-overlay-data:nth-child(3)');
    // var precision_enhance = clone.querySelector('.precision-ultra-enhancer');
    var hdImageDiv = clone.querySelector('.hd_image_div');

    // var dynamicClass = "favoriteImage" + item.id;
    // var favImg = clone.querySelector('.favcheckimg');
    // favImg.classList.add(dynamicClass);

    // favImg.setAttribute('onclick', `addRemovefavorite('${item.id}')`);
    // checkbox.setAttribute('onclick', `getMultipleImages('${item.id}')`);
    // previewInputBtn.setAttribute('onclick', `previewImage('${item.original_url}')`);
    previewOutputBtn.setAttribute('onclick', `previewImage('${item.original_url}','${item.generated_url}')`);

    // downloadBtn.href = item.generated_url;
    // downloadInputBtn.dataset.downloadUrl = item.original_url;
    downloadOutputBtn.dataset.downloadUrl = item.generated_url;
    // previewInputBtn.dataset.img = item.original_url;
    previewOutputBtn.dataset.img = item.generated_url;
    // useAsInputImage.dataset.img = item.original_url;
    // useAsInputImage.dataset.sec = item.section;
    // useAsOutputImage.dataset.img = item.generated_url;
    // useAsOutputImage.dataset.sec = item.section;
    fullHdBtn.dataset.img = item.generated_url;
    fullHdBtn.dataset.sec = item.section;

    // editImage.dataset.inputImg = item.original_url;
    // editImage.dataset.outputImg = item.generated_url;
    // editImage.dataset.sec = item.section;
    // feedback_btn.dataset.img = item.generated_url;
    // precision_enhance.dataset.img = item.generated_url;
    // if (editAsFillSpace) {
    //     editAsFillSpace.dataset.img = item.generated_url;
    // }
    // inputImg.src = item.original_url;
    outputImg.src = item.generated_url;
    if (item.style !== undefined && item.style !== '' && item.style != 'N/A') {
        styleSpan.textContent = "Style: " + item.style;
    } else {
        styleSpan.style.background = 'transparent';
    }
    if (item.room_type !== undefined && item.room_type !== '' && item.room_type != 'N/A') {
        if(item.section == 1){
            roomTypeSpan.textContent = "House Angle: " + item.room_type;
        }else if(item.section == 2){
            roomTypeSpan.textContent = "Garden Type: " + item.room_type;
        }else{
            roomTypeSpan.textContent = "Room Type: " + item.room_type;
        }
    } else {
        roomTypeSpan.style.background = 'transparent';
    }
    if (item.hd_image == 1) {
        hdImageDiv.style.display = 'flex';
        fullHdBtn.style.display = 'none';
    } else {
        hdImageDiv.style.display = 'none';
        // fullHdBtn.style.display = 'block';
    }

    return clone;
}

$("body").on('click', '.close-decor-stag', async function () {
    $('#cropImageModal').modal('hide');
});

var mainImage,textureImage = '';
async function loadImageCropperForStyleTransfer() {
    $('#uploading_instruction').modal('hide');
    hasTransparentPixels = false;
    const [file] = fileInput2.files;
    var image = '';
    image = await toBase64(file);

    if(dataPage == 'style_transfer' || dataPage == 'color_swap' || dataPage == 'design_transfer' || dataPage == 'floor_editor'){
        ipsValidateTextureImage(file, () => {
            clearSecPaintingStag();
            loadImageToStageSec(image);
            textureImage = image.result;
        }, (error) => {
            ipsFailOnValidImage(error, min_height_width = 512);
            fileInput.value = '';
        }, 512);
    }
}

function loadImageToStageSec(image) {
    let img = document.createElement('img');
    img.src = image.result;
    const stageSec = document.getElementById('painting-stag-sec');
    stageSec.innerHTML = '';
    stageSec.appendChild(img);

    let uploadContentElements = document.getElementsByClassName('upload-content');
    for (let element of uploadContentElements) {
        element.classList.add('hidden');
    }
}

function clearSecPaintingStag() {
    imageLayerSec.destroyChildren();
    pixelRatio = 1;
    setStagW(paintingStagSec, paintingStagOriginalHeight);
    setStagH(paintingStagSec, paintingStagOriginalHeight);
}

async function _generateStyleTransferDesign(sec,el){
    page = 1;
    getInPaintingGeneratedDesigns();
    const generateDesignBtn = el;
    const spinner = generateDesignBtn.querySelector('span#submit');
    const tabs = document.querySelectorAll('.gs-option-flex a');
    const previousPageButton = document.querySelector('.previous_page');

    disableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
    // $('.full_hd_quality').addClass('disable-btn');
    // $('.edit-as-fill-space').addClass('disable-btn');
    // $('.precision-ultra-enhancer').addClass('disable-btn');
    // projectButton.disabled = true;
    // deleteButton.disabled = true;

    $('.ai-upload-latest-designs')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });

    var checkboxMaskingLabelString = checkboxMaskingLabel.join(',');
    var mode = modeValue.value;

    if (!imageLayer.hasChildren()) {
        alert('Upload Image');
        generateDesignBtn.disabled = false;
        generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
        return;
    }

    if (!hasTransparentPixels && dataPage != 'sky-color' && dataPage != 'design_transfer' && dataPage != 'floor_editor') {
        if (!brushLayer.hasChildren()) {
            let error_message = 'Ensure your image is masked before submitting!';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
            return;
        }
    }

    if (prompt == '') {
        alert('Add Prompt');
        generateDesignBtn.disabled = false;
        generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
        return false;
    }
    // var original_base64 = imageCropper.getCroppedCanvas().toDataURL("image/png");
    var original_base64 = croppedImage;
    var texture_base64 = textureImage;
    var masked_base64 = await getMaskedImages();
    // Disable AI category Pill
    // _updateAiCatePillsStatus('disable');

    const promptInputDesign = document.querySelector(`#promptInputDesign${sec}`);
    const promptInputRoomType = document.querySelector(`#promptInputRoomType${sec}`);
    const noOftexture = document.querySelector(`#no_of_texture`);
    const rgbColor = document.querySelector(`#colorPickerValue`);
    const noOfdesc = document.querySelector(`#no_of_des${sec}`);

    var segmentType = segmentation ? segmentation : 'false';
    var designStyle = promptInputDesign ? promptInputDesign.value : "" ;
    var roomType = promptInputRoomType ? promptInputRoomType.value : "" ;
    var no_of_texture = noOftexture ? noOftexture.value : "" ;
    var rgb_color = rgbColor ? rgbColor.value : "" ;
    var noOfDesign = noOfdesc ? noOfdesc.value : "" ;

    if (texture_base64 == '' && rgb_color == '' && dataPage == 'color_swap') {
        let error_message = 'Upload Texture Image Or select any color from color picker!';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }

    if (texture_base64 == '' && (dataPage == 'design_transfer' || dataPage == 'style_transfer' || dataPage == 'floor_editor')) {
        let error_message = 'Upload Texture Image!';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }



    if(dataPage == 'floor_editor'){
        generationDivLoader(1,croppedImage);
    }else{
        generationDivLoader(noOfDesign,croppedImage);
    }

    var formData = new FormData();
    formData.append("no_of_Design", noOfDesign);
    formData.append("segmentType", segmentType);
    formData.append("init_images", original_base64);
    formData.append("mask", masked_base64);
    formData.append("texture_image", texture_base64);
    formData.append("modeType", mode);
    formData.append("designtype", sec);
    var inPaintUrl = '';
    if(dataPage == 'color_swap'){
        formData.append("objects", checkboxMaskingLabelString);
        formData.append("rgb_color", rgb_color);
        inPaintUrl = "/runpod/paint-visualizer"
    }else if(dataPage == 'style_transfer'){
        formData.append("no_of_texture", no_of_texture);
        inPaintUrl = "/runpod/style_transfer";
    }else if(dataPage == 'design_transfer'){
        inPaintUrl = "/runpod/design_transfer";
    }else if(dataPage == 'floor_editor'){
        formData.append("no_of_texture", no_of_texture);
        inPaintUrl = "/runpod/floor_editor";
    }

    return await fetch(inPaintUrl, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: "include",
        crossDomain: true,
        headers: {
            accept: 'multipart/form-data',
            'Access-Control-Allow-Origin': '*',
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
        },
        body: formData,
    }).then(response => {
        if (response.status === 200) {
            return response.text();
        }
        throw 'Server error';
    }).then(result => {
        var resultJsonFormat = JSON.parse(result);
        var generatedImageList = ''
        generatedImageList = resultJsonFormat.Sucess.generated_image;
        originalImage = resultJsonFormat.Sucess.original_image;
        let storedIds = resultJsonFormat.storedIds;
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        if(dataPage == 'floor_editor'){
            removeLoaderDivs(1);
        }else{
            removeLoaderDivs(noOfDesign);
        }
        // generateDesignBtn.disabled = false;
        // generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
        // $('.full_hd_quality').removeClass('disable-btn');
        // $('.edit-as-fill-space').removeClass('disable-btn');
        // $('.precision-ultra-enhancer').removeClass('disable-btn');
        // projectButton.disabled = false;
        // deleteButton.disabled = false;
        // Iterate over the list of images
        generatedImageList.forEach((image, index) => {
            let design = {
                id: storedIds[index],
                original_url: originalImage,
                generated_url: image,
                style: designStyle,
                room_type: roomType,
                show_data: true,
                section: sec,
                hd_image: 0,
            };
            var itemHtml = generatedInPaintingItem(design);
            // addNewDesignImage(design);
            var data = document.getElementById(`all_data0`);
            data.insertBefore(itemHtml, data.firstChild);
        });
        setTimeout(function () {
            $('html, body').animate({
                scrollTop: virtualStagDesignContainer.offsetTop
            }, 100);
        }, 500);
        // Enable AI category Pill
        _updateAiCatePillsStatus('enable');
    }).catch(error => {
        // $('.full_hd_quality').removeClass('disable-btn');
        // $('.edit-as-fill-space').removeClass('disable-btn');
        // $('.precision-ultra-enhancer').removeClass('disable-btn');
        // projectButton.disabled = false;
        // deleteButton.disabled = false;
        console.log("Something went wrong. Please try again in some time.");
        // alert("Something went wrong. Please try again in some time.");
    });
}

let collegeToRenderImages = [];
//Load Collage Image To Stag
function loadCollageImageToStage(image) {
    // $('#uploading_instruction').modal('show');
    // Initialize Fabric.js canvas
    paintingCollageStag.clear();
    var bin;
    var selectedObject;
    var backimage = null;
    loadroomtrendimages();
    fabric.Image.fromURL(image, function (img) {
        backimage = img;
        var canvasWidth = paintingCollageStag.getWidth();
        var canvasHeight = paintingCollageStag.getHeight();

        // var scaleFactor = Math.min(canvasWidth / img.width, canvasHeight / img.height);


        // img.scaleToWidth(paintingStagOriginalWidth);
        // img.scaleToHeight(paintingStagOriginalHeight);

        // img.scale(scaleFactor);
        // img.set({
        //     selectable: false,
        //     scaleX: canvasWidth / img.width,
        //     scaleY: canvasHeight / img.height,
        //     left: 0,
        //     top: 0,
        //     originX: 'left',
        //     originY: 'top'
        // });
        // mainImage = img;
        // const imgWidth = img.width;
        // const imgHeight = img.height;
        // Set canvas dimensions based on image dimensions
        // paintingCollageStag.setWidth(img.scaleToWidth(paintingStagOriginalWidth));
        // paintingCollageStag.setHeight(img.scaleToHeight(paintingStagOriginalHeight));


        let canvasAspect = paintingCollageStag.width / paintingCollageStag.height;
        let imgAspect = img.width / img.height;
        let scaleFactor;
        if (imgAspect >= canvasAspect) {
            // Landscape or square
            scaleFactor = paintingCollageStag.width / img.width;
        } else {
            // Portrait
            scaleFactor = paintingCollageStag.height / img.height;
        }

        img.scale(scaleFactor);

        // Position the image at the center
        mainImage = img;
        img.set({
            selectable: false,
            left: (paintingCollageStag.width - img.getScaledWidth()) / 2,
            top: (paintingCollageStag.height - img.getScaledHeight()) / 2,
        });

        // $.ajax({
        //     type: 'POST',
        //     url: '/uploadImageToGoogleCloudCollegeToRender',
        //     data: { data: image },
        //     success: function (response) {
        //         if(response.success){
        //             imageCoordinates['image_url'] = response.url;
        //             imageCoordinates['image_size'] = {
        //                 "originalWidth": backimage.width,
        //                 "originalHeight": backimage.height,
        //                 "width": img.getScaledWidth(),
        //                 "height": img.getScaledHeight()
        //             };
        //         }
        //     },
        //     error: function (error) {
        //         console.error('AJAX request failed', error);
        //     }
        // });

        collegeToRenderImages.push(img);
        paintingCollageStag.add(img);
    });

    setTimeout(function () {
        $('.gs-modal-uploading_instruction_slider')[0].slick.refresh();
    }, 250);
    setTimeout(function () {
        $('.top-menu-bar-first').css('display', 'none');
        $('.upload-image-container').css('display', 'none');
        $('.searched_product_result').css('display', 'none');
        $('.top-menu-bar-second').css('display', 'flex');
        $('.image-mask-container').css('display', 'block');
        $('.segment-masking-container').css('display', 'block');
        if (dataPage == 'redesign' || dataPage == 'productSearch' || dataPage == 'sky-color' || dataPage == 'rostMyHome' || dataPage == 'collage_to_render') {
            $('.redesign-designs-tabs').css('display', 'none');
            $("#loading_brilliance").modal('hide');
        }
    }, 2000)
}
function allowDrop(e) {
    e.preventDefault();
}
//dragElement function called on ondrag event.
function dragElement(e) {
    var data = e.dataTransfer.setData("id", e.target.id); //transfer the "data" i.e. id of the target dragged.
    //console.log("Dropped element ID:", data);
    var imag = document.getElementById(data); // Get the target image info through its id.
    //console.log("Fetched element:", imag);
}

function moveElementOnCanvas(e){
    e.preventDefault();
    var data = e.target.id;
    var imag = document.getElementById(data);

    var img = new fabric.Image(imag, {
        left: 100,
        top: 100,
        hasRotatingPoint: true,
        lockRotation: false,
    });

    // Scale the image to a minimum size
    var minScaleSize = 100; // Set the minimum size as needed
    var minScaleFactor = Math.min(minScaleSize / img.width, minScaleSize / img.height);
    img.scale(minScaleFactor);

    // Add delete button
    var deleteButton = new fabric.Circle({
        radius: 10, // Increased button size
        fill: 'red',
        originX: 'center',
        originY: 'center',
        selectable: false,
        hoverCursor: 'pointer',
        visible: false
    });
    var deleteIcon = new fabric.Text('✖', {
        fontSize: 12, // Increased icon size
        fill: 'white',
        originX: 'center',
        originY: 'center',
        selectable: false,
        visible: false,
        hoverCursor: 'pointer', // Set hover cursor for the "X" text
    });

    // Set initial position for delete button and icon
    updateDeleteButtonPosition(img, deleteButton, deleteIcon);

    // Handle delete button events
    paintingCollageStag.on('mouse:down', function (e) {
        var pointer = paintingCollageStag.getPointer(e.e);
        if (
            pointer.x >= deleteButton.left - deleteButton.radius &&
            pointer.x <= deleteButton.left + deleteButton.radius &&
            pointer.y >= deleteButton.top - deleteButton.radius &&
            pointer.y <= deleteButton.top + deleteButton.radius
        ) {
            deleteObject(img, deleteButton, deleteIcon);
        }
    });
    $(document).on( "keydown", function(e) {
        if(e.which == 46){
            // var pointer = paintingCollageStag.getPointer(e.e);
            // if (
            //     pointer.x >= deleteButton.left - deleteButton.radius &&
            //     pointer.x <= deleteButton.left + deleteButton.radius &&
            //     pointer.y >= deleteButton.top - deleteButton.radius &&
            //     pointer.y <= deleteButton.top + deleteButton.radius
            // ) {
                deleteObject(img, deleteButton, deleteIcon);
            // }
        }
    });

    deleteButton.on('mouseover', function () {
        deleteButton.fill = 'darkred'; // Change button color on hover
        deleteIcon.fill = 'white'; // Change icon color on hover
        deleteButton.hoverCursor = 'pointer'; // Set hover cursor for delete button
        paintingCollageStag.renderAll();
    });

    deleteButton.on('mouseout', function () {
        deleteButton.fill = 'red'; // Restore button color on mouseout
        deleteIcon.fill = 'white'; // Restore icon color on mouseout
        deleteButton.hoverCursor = 'default'; // Restore default hover cursor for delete button
        paintingCollageStag.renderAll();
    });

    // Add objects to the canvas
    paintingCollageStag.add(img);
    paintingCollageStag.add(deleteButton);
    paintingCollageStag.add(deleteIcon);
    paintingCollageStag.renderAll();

    // Set cursor styles
    paintingCollageStag.defaultCursor = 'default';
    paintingCollageStag.hoverCursor = 'default';
    img.hoverCursor = 'move';

    // Ensure buttons stay with the image
    img.on('moving', function (e) {
        updateDeleteButtonPosition(img, deleteButton, deleteIcon);
        paintingCollageStag.renderAll();
        paintingCollageStag.bringToFront(deleteButton);
        paintingCollageStag.bringToFront(deleteIcon);
        deleteButton.hoverCursor = 'pointer'; // Update hover cursor for delete button on move
        paintingCollageStag.renderAll();
    });

    img.on('modified', function () {
        updateDeleteButtonPosition(img, deleteButton, deleteIcon);
        paintingCollageStag.renderAll();
        paintingCollageStag.bringToFront(deleteButton);
        paintingCollageStag.bringToFront(deleteIcon);
        deleteButton.hoverCursor = 'pointer'; // Update hover cursor for delete button on move
        paintingCollageStag.renderAll();
    });

    img.on('scaling', function () {
        updateDeleteButtonPosition(img, deleteButton, deleteIcon);
        paintingCollageStag.renderAll();
        paintingCollageStag.bringToFront(deleteButton);
        paintingCollageStag.bringToFront(deleteIcon);
        deleteButton.hoverCursor = 'pointer'; // Update hover cursor for delete button on move
        paintingCollageStag.renderAll();
    });

    // Show buttons when image is selected
    img.on('selected', function () {
        deleteButton.visible = true;
        deleteIcon.visible = true;
        paintingCollageStag.renderAll();
    });

    // Hide buttons when image is deselected
    img.on('deselected', function () {
        deleteButton.visible = false;
        deleteIcon.visible = false;
        paintingCollageStag.renderAll();
    });
}

function dropElement(e) {
    e.preventDefault();
    var data = e.dataTransfer.getData("id");
    // console.log("Dropped element ID:", data);
    var imag = document.getElementById(data);
    // console.log("Fetched element:", imag);

    var img = new fabric.Image(imag, {
        left: e.layerX - 80,
        top: e.layerY - 40,
        hasRotatingPoint: true,
        lockRotation: false,
    });

    // Scale the image to a minimum size
    var minScaleSize = 100; // Set the minimum size as needed
    var minScaleFactor = Math.min(minScaleSize / img.width, minScaleSize / img.height);
    img.scale(minScaleFactor);

    // Add delete button
    var deleteButton = new fabric.Circle({
        radius: 10, // Increased button size
        fill: 'red',
        originX: 'center',
        originY: 'center',
        selectable: false,
        hoverCursor: 'pointer',
        visible: false
    });
    var deleteIcon = new fabric.Text('✖', {
        fontSize: 12, // Increased icon size
        fill: 'white',
        originX: 'center',
        originY: 'center',
        selectable: false,
        visible: false,
        hoverCursor: 'pointer', // Set hover cursor for the "X" text
    });

    // Set initial position for delete button and icon
    updateDeleteButtonPosition(img, deleteButton, deleteIcon);

    // Handle delete button events
    paintingCollageStag.on('mouse:down', function (e) {
        var pointer = paintingCollageStag.getPointer(e.e);
        if (
            pointer.x >= deleteButton.left - deleteButton.radius &&
            pointer.x <= deleteButton.left + deleteButton.radius &&
            pointer.y >= deleteButton.top - deleteButton.radius &&
            pointer.y <= deleteButton.top + deleteButton.radius
        ) {
            deleteObject(img, deleteButton, deleteIcon);
        }
    });
    $(document).on( "keydown", function(e) {
        if(e.which == 46){
            // var pointer = paintingCollageStag.getPointer(e.e);
            // if (
            //     pointer.x >= deleteButton.left - deleteButton.radius &&
            //     pointer.x <= deleteButton.left + deleteButton.radius &&
            //     pointer.y >= deleteButton.top - deleteButton.radius &&
            //     pointer.y <= deleteButton.top + deleteButton.radius
            // ) {
                deleteObject(img, deleteButton, deleteIcon);
            // }
        }
    });

    deleteButton.on('mouseover', function () {
        deleteButton.fill = 'darkred'; // Change button color on hover
        deleteIcon.fill = 'white'; // Change icon color on hover
        deleteButton.hoverCursor = 'pointer'; // Set hover cursor for delete button
        paintingCollageStag.renderAll();
    });

    deleteButton.on('mouseout', function () {
        deleteButton.fill = 'red'; // Restore button color on mouseout
        deleteIcon.fill = 'white'; // Restore icon color on mouseout
        deleteButton.hoverCursor = 'default'; // Restore default hover cursor for delete button
        paintingCollageStag.renderAll();
    });

    // Add objects to the canvas
    paintingCollageStag.add(img);
    paintingCollageStag.add(deleteButton);
    paintingCollageStag.add(deleteIcon);
    paintingCollageStag.renderAll();

    // Set cursor styles
    paintingCollageStag.defaultCursor = 'default';
    paintingCollageStag.hoverCursor = 'default';
    img.hoverCursor = 'move';

    // Ensure buttons stay with the image
    img.on('moving', function () {
        updateDeleteButtonPosition(img, deleteButton, deleteIcon);
        paintingCollageStag.renderAll();
        paintingCollageStag.bringToFront(deleteButton);
        paintingCollageStag.bringToFront(deleteIcon);
        deleteButton.hoverCursor = 'pointer'; // Update hover cursor for delete button on move
        paintingCollageStag.renderAll();
    });

    img.on('modified', function () {
        updateDeleteButtonPosition(img, deleteButton, deleteIcon);
        paintingCollageStag.renderAll();
        paintingCollageStag.bringToFront(deleteButton);
        paintingCollageStag.bringToFront(deleteIcon);
        deleteButton.hoverCursor = 'pointer'; // Update hover cursor for delete button on move
        paintingCollageStag.renderAll();
    });

    img.on('scaling', function () {
        updateDeleteButtonPosition(img, deleteButton, deleteIcon);
        paintingCollageStag.renderAll();
        paintingCollageStag.bringToFront(deleteButton);
        paintingCollageStag.bringToFront(deleteIcon);
        deleteButton.hoverCursor = 'pointer'; // Update hover cursor for delete button on move
        paintingCollageStag.renderAll();
    });

    // Show buttons when image is selected
    img.on('selected', function () {
        deleteButton.visible = true;
        deleteIcon.visible = true;
        paintingCollageStag.renderAll();
    });

    // Hide buttons when image is deselected
    img.on('deselected', function () {
        deleteButton.visible = false;
        deleteIcon.visible = false;
        paintingCollageStag.renderAll();
    });
}


function updateDeleteButtonPosition(img, deleteButton, deleteIcon) {
    // var buttonOffsetX = 2; // Increased horizontal offset for closer positioning
    // var buttonOffsetY = -30; // Increased vertical offset for closer positioning
    deleteButton.set({ left: (img.left + img.width * img.scaleX) - ((((img.left + img.width * img.scaleX)) * 10) /100), top: img.top });
    // deleteButton.set({ left: (img.left + (img.left / 2)), top: (img.top) });
    deleteIcon.set({ left: deleteButton.left, top: deleteButton.top });

    deleteButton.bringToFront(img);
    paintingCollageStag.bringToFront(deleteIcon);
    paintingCollageStag.renderAll();
}

function deleteObject(img, deleteButton, deleteIcon) {
    paintingCollageStag.remove(img);
    paintingCollageStag.remove(deleteButton);
    paintingCollageStag.remove(deleteIcon);
    paintingCollageStag.renderAll();
}
$("#dragUploadBtn").on('click', function () {
    // handleUpload();
    $("#uploadInput").trigger('click');
});

function mergeImages() {
    if(mainImage === null){
        let error_message = 'Main image is missing, Please upload the main image';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        return false;
    }
    const objects = paintingCollageStag.getObjects();
    currLoc = $(location).attr('href');
    if((currLoc.indexOf('room-blend') != -1) && (objects.length <= 1)){
        let error_message = 'Please add at least 1 Custom element to proceed.';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        return null;
    }
    if (objects.length === 0) {
        let error_message = 'No images to merge.';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        return null;
    }

    // Calculate the bounding box of all objects on the canvas
    let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;

    objects.forEach((obj) => {
        const boundingRect = obj.getBoundingRect();

        minX = Math.min(minX, boundingRect.left);
        minY = Math.min(minY, boundingRect.top);
        maxX = Math.max(maxX, boundingRect.left + boundingRect.width);
        maxY = Math.max(maxY, boundingRect.top + boundingRect.height);
    });

    if (isNaN(minX) || isNaN(minY) || isNaN(maxX) || isNaN(maxY)) {
        console.log('Error in calculating bounding box dimensions.');
        return null;
    }
    const width = maxX - minX;
    const height = maxY - minY;

    if (width <= 0 || height <= 0) {
        console.log('Calculated width or height is 0, no valid merge area.');
        return null;
    }
    // Create a new canvas to hold the merged image
    const mergedCanvas = document.createElement('canvas');
    const mergedCtx = mergedCanvas.getContext('2d');

    // Set the dimensions of the merged canvas
    const fullHdWidth = mainImage.height;
    const fullHdHeight = mainImage.width;

    const aspectRatio = fullHdWidth / fullHdHeight;
    let scaledWidth, scaledHeight;

    if (width / height > aspectRatio) {
        // Scale based on width
        scaledWidth = fullHdWidth;
        scaledHeight = fullHdWidth / (width / height);
    } else {
        // Scale based on height
        scaledHeight = fullHdHeight;
        scaledWidth = fullHdHeight * (width / height);
    }

    // Set the dimensions of the merged canvas
    mergedCanvas.width = scaledWidth;
    mergedCanvas.height = scaledHeight;
    console.log("Canvas", mergedCanvas, mainImage.width * mainImage.scaleX, mainImage.height * mainImage.scaleY, mainImage);
    console.log(`Merged canvas dimensions: ${width}x${height}`);
    // Draw each image onto the merged canvas within the bounding box
    objects.forEach((obj) => {
        const left = obj.left || 0;
        const top = obj.top || 0;
        const originalWidth = obj.width || 0;
        const originalHeight = obj.height || 0;
        const scaleX = obj.scaleX || 1;
        const scaleY = obj.scaleY || 1;

        const adjustedWidth = originalWidth * scaleX;
        const adjustedHeight = originalHeight * scaleY;

        if (obj !== mainImage) {
            mergedCtx.drawImage(
                obj._element,
                (left - minX) * (scaledWidth / width),
                (top - minY) * (scaledHeight / height),
                adjustedWidth * (scaledWidth / width),
                adjustedHeight * (scaledHeight / height)
            );
        } else {
            const mainImageScaleX = mainImage.scaleX || 1;
            const mainImageScaleY = mainImage.scaleY || 1;
            const mainAdjustedWidth = mainImage.width * mainImageScaleX;
            const mainAdjustedHeight = mainImage.height * mainImageScaleY;
            mergedCtx.drawImage(
                mainImage._element,
                (mainImage.left - minX) * (scaledWidth / width),
                (mainImage.top - minY) * (scaledHeight / height),
                mainAdjustedWidth * (scaledWidth / width),
                mainAdjustedHeight * (scaledHeight / height)
            );
        }
    });

    // Convert the merged canvas to a Fabric.js image object
    const mergedImage = new fabric.Image(mergedCanvas, {
        selectable: false
    });

    // Optionally, clear the original canvas and add the merged image
    // paintingCollageStag.clear().add(mergedImage);
    return mergedImage;
}

function mergeMaskImages() {
    if (mainImage === null) {
        alert("Main image is missing, Please upload the main image");
        return false;
    }

    const objects = paintingCollageStag.getObjects();
    currLoc = $(location).attr('href');
    if ((currLoc.indexOf('collage-to-render') != -1) && (objects.length <= 1)) {
        alert("Please add at least 1 Custom element to proceed.");
        return null;
    }
    if (objects.length === 0) {
        console.log('No images to merge.');
        return null;
    }

    // Calculate the bounding box of all objects on the canvas
    let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;

    objects.forEach((obj) => {
        const boundingRect = obj.getBoundingRect();
        minX = Math.min(minX, boundingRect.left);
        minY = Math.min(minY, boundingRect.top);
        maxX = Math.max(maxX, boundingRect.left + boundingRect.width);
        maxY = Math.max(maxY, boundingRect.top + boundingRect.height);
    });

    if (isNaN(minX) || isNaN(minY) || isNaN(maxX) || isNaN(maxY)) {
        console.log('Error in calculating bounding box dimensions.');
        return null;
    }
    const width = maxX - minX;
    const height = maxY - minY;

    if (width <= 0 || height <= 0) {
        console.log('Calculated width or height is 0, no valid merge area.');
        return null;
    }

    // Create a new canvas to hold the mask
    const maskCanvas = document.createElement('canvas');
    const maskCtx = maskCanvas.getContext('2d');

    // Set the dimensions of the mask canvas
    const fullHdWidth = mainImage.width;
    const fullHdHeight = mainImage.height;

    maskCanvas.width = fullHdWidth;
    maskCanvas.height = fullHdHeight;

    // Ensure the mask canvas is filled with white (main image area)
    maskCtx.fillStyle = 'white';
    maskCtx.fillRect(0, 0, fullHdWidth, fullHdHeight);

    // Draw sub-objects on the mask canvas
    objects.forEach((obj) => {
        const scaleX = obj.scaleX || 1;
        const scaleY = obj.scaleY || 1;
        const left = obj.left || 0;
        const top = obj.top || 0;
        const objWidth = obj.width || 0;
        const objHeight = obj.height || 0;

        if (obj !== mainImage) {
            // Create an offscreen canvas to get the alpha channel
            const offscreenCanvas = document.createElement('canvas');
            const offscreenCtx = offscreenCanvas.getContext('2d');
            offscreenCanvas.width = objWidth;
            offscreenCanvas.height = objHeight;

            offscreenCtx.drawImage(obj.toCanvasElement(), 0, 0, objWidth, objHeight);

            // Get the image data and extract the alpha channel
            const imageData = offscreenCtx.getImageData(0, 0, objWidth, objHeight);
            const data = imageData.data;

            for (let i = 0; i < data.length; i += 4) {
                const alpha = data[i + 3];
                if (alpha > 0) {
                    data[i] = 0; // Red
                    data[i + 1] = 0; // Green
                    data[i + 2] = 0; // Blue
                    data[i + 3] = 255; // Alpha
                }
            }

            offscreenCtx.putImageData(imageData, 0, 0);

            // Draw the alpha channel onto the mask canvas
            maskCtx.drawImage(
                offscreenCanvas,
                (left - minX) * (fullHdWidth / width),
                (top - minY) * (fullHdHeight / height),
                objWidth * scaleX * (fullHdWidth / width),
                objHeight * scaleY * (fullHdHeight / height)
            );
        }
    });

    // Create a new canvas to hold the final output
    const outputCanvas = document.createElement('canvas');
    const outputCtx = outputCanvas.getContext('2d');

    // Set the dimensions of the masked canvas
    outputCanvas.width = fullHdWidth;
    outputCanvas.height = fullHdHeight;

    // Apply the mask
    outputCtx.drawImage(maskCanvas, 0, 0, fullHdWidth, fullHdHeight);

    // Convert the masked canvas to a Fabric.js image object
    const maskedImage = new fabric.Image(outputCanvas, {
        selectable: false
    });

    return maskedImage;
}

function keepObjectInBounds(obj) {
    var movingObject = obj.target;
    console.log(movingObject);
    // Check if the moving object is an image
    // if (movingObject.type === 'image') {
        // Get the boundaries of the main image
        // var mainImageBoundaries = mainImage.getBoundingRect();

        // // Check if the moving object is going out of the main image boundaries
        // if (movingObject.left < mainImageBoundaries.left) {
        //     movingObject.left = mainImageBoundaries.left;
        // }
        // if (movingObject.top < mainImageBoundaries.top) {
        //     movingObject.top = mainImageBoundaries.top;
        // }
        // if (movingObject.left + movingObject.width > mainImageBoundaries.left + mainImageBoundaries.width) {
        //     movingObject.left = mainImageBoundaries.left + mainImageBoundaries.width - movingObject.width;
        // }
        // if (movingObject.top + movingObject.height > mainImageBoundaries.top + mainImageBoundaries.height) {
        //     movingObject.top = mainImageBoundaries.top + mainImageBoundaries.height - movingObject.height;
        // }
    // }
}

var imageData;
function ClickElementOnCanvasCollageToRander(e){
    e.preventDefault();
    if(mainImage === null){
        alert("Main image is missing, Please upload the main image");
        return false;
    }
	// create a rect object
    var deleteIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3E%3Csvg version='1.1' id='Ebene_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='595.275px' height='595.275px' viewBox='200 215 230 470' xml:space='preserve'%3E%3Ccircle style='fill:%23F44336;' cx='299.76' cy='439.067' r='218.516'/%3E%3Cg%3E%3Crect x='267.162' y='307.978' transform='matrix(0.7071 -0.7071 0.7071 0.7071 -222.6202 340.6915)' style='fill:white;' width='65.545' height='262.18'/%3E%3Crect x='266.988' y='308.153' transform='matrix(0.7071 0.7071 -0.7071 0.7071 398.3889 -83.3116)' style='fill:white;' width='65.544' height='262.179'/%3E%3C/g%3E%3C/svg%3E";
    var cloneIcon = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='512' height='512' x='0' y='0' viewBox='0 0 1.693 1.693' style='enable-background:new 0 0 512 512' xml:space='preserve' fill-rule='evenodd' class=''%3E%3Cg%3E%3Ccircle cx='.847' cy='.847' r='.847' fill='%23ffffff' opacity='1' data-original='%23ffffff' class=''%3E%3C/circle%3E%3Cg fill='%23fff'%3E%3Cpath d='m1.183.258.116.116.052.052.116.11v.113A.044.044 0 0 1 1.454.64L1.291.485 1.239.434 1.123.318a.042.042 0 0 1 0-.06.042.042 0 0 1 .06 0z' fill='%23000000' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath fill-rule='nonzero' d='M.626.246h.53a.035.035 0 0 1 .035.038V.52h.24c.02 0 .036.016.036.035v.592a.082.082 0 0 1-.022.056.076.076 0 0 1-.056.024H.626a.076.076 0 0 1-.055-.024.082.082 0 0 1-.022-.056V.326C.549.305.557.285.57.27A.076.076 0 0 1 .626.246zm.478.087h-.46c-.002 0-.004 0-.005.002a.012.012 0 0 0-.003.008v.788c0 .003.001.006.003.008a.006.006 0 0 0 .004.002h.73l.004-.002a.012.012 0 0 0 .003-.008V.608h-.216a.06.06 0 0 1-.06-.06z' fill='%23000000' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath fill-rule='nonzero' d='M.406.448h.151v.087H.422L.418.537a.012.012 0 0 0-.003.009v.787c0 .004.001.007.003.009a.006.006 0 0 0 .004.002h.73l.004-.002a.012.012 0 0 0 .003-.009v-.12h.087v.137a.082.082 0 0 1-.022.056.076.076 0 0 1-.055.025H.406a.076.076 0 0 1-.056-.025.082.082 0 0 1-.022-.056V.53C.328.507.336.487.35.473A.076.076 0 0 1 .406.448z' fill='%23000000' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath d='M.736.395h.268c.023 0 .042.019.042.042 0 .023-.019.042-.042.042H.736A.042.042 0 0 1 .694.437c0-.023.019-.042.042-.042zM.736.543h.268c.023 0 .042.019.042.042 0 .023-.019.042-.042.042H.736A.042.042 0 0 1 .694.585c0-.023.019-.042.042-.042zM.736.69h.541c.023 0 .042.02.042.043 0 .023-.02.042-.042.042H.736A.042.042 0 0 1 .694.733C.694.71.713.691.736.691zM.736.839H1.156c.023 0 .042.019.042.042 0 .023-.02.043-.042.043H.736A.042.042 0 0 1 .694.88C.694.858.713.84.736.84z' fill='%23000000' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3C/g%3E%3C/g%3E%3C/svg%3E";
    var inverseHorizontalIcon = "data:image/svg+xml,%3Csvg width='512' height='512' xmlns='http://www.w3.org/2000/svg' color='black' role='img' class='svg-inline--fa fa-arrows-repeat ' data-icon='arrows-repeat' data-prefix='fal' focusable='false' aria-hidden='true'%3E%3Cg%3E%3Ctitle%3ELayer 1%3C/title%3E%3Cellipse ry='241' rx='240' id='svg_2' cy='255' cx='252' fill='%23ffffff'/%3E%3Cpath transform='rotate(0.718491 249 267)' stroke='null' id='svg_1' d='m93.65801,276.86639c-5.67695,-0.30832 -10.06368,-4.9332 -9.80564,-10.35971l0.25804,-4.9332c3.03201,-57.78007 52.89884,-103.10382 113.40996,-103.10382l138.31112,0l-37.02919,-32.18911c-4.1932,-3.63823 -4.51576,-9.92806 -0.70962,-13.93628s10.38624,-4.31655 14.57944,-0.67831l56.76949,49.33197c2.12886,1.84995 3.35456,4.50154 3.35456,7.27647s-1.2257,5.42652 -3.35456,7.27647l-56.76949,49.33197c-4.1932,3.63823 -10.7733,3.39157 -14.57944,-0.67831s-3.54809,-10.29805 0.70962,-13.93628l37.02919,-32.06578l-138.31112,0c-49.47977,0 -90.3151,37.12231 -92.76651,84.35767l-0.25804,4.9332c-0.25804,5.42652 -5.16086,9.61973 -10.83781,9.37307zm310.68394,-19.73279c5.67695,0.24666 10.06368,4.9332 9.80564,10.35971l-0.25804,4.9332c-3.03201,57.78007 -52.89884,103.10382 -113.40996,103.10382l-138.31112,0l37.02919,32.18911c4.1932,3.63823 4.51576,9.92806 0.70962,13.93628s-10.38624,4.31655 -14.57944,0.67831l-56.76949,-49.33197c-2.12886,-1.84995 -3.35456,-4.50154 -3.35456,-7.27647s1.2257,-5.42652 3.35456,-7.27647l56.76949,-49.33197c4.1932,-3.63823 10.7733,-3.39157 14.57944,0.67831s3.54809,10.29805 -0.70962,13.93628l-37.02919,32.06578l138.31112,0c49.47977,0 90.3151,-37.12231 92.76651,-84.35767l0.25804,-4.9332c0.25804,-5.42652 5.16086,-9.61973 10.83781,-9.37307z' fill='currentColor'/%3E%3Cpath id='svg_3' d='m456,164' opacity='NaN' stroke='null' fill='currentColor'/%3E%3C/g%3E%3C/svg%3E";
    var inverseVerticalIcon = "data:image/svg+xml,%3Csvg width='512' height='512' xmlns='http://www.w3.org/2000/svg' color='black' role='img' class='svg-inline--fa fa-arrows-repeat ' style='transform: rotate(90deg);' data-icon='arrows-repeat' data-prefix='fal' focusable='false' aria-hidden='true'%3E%3Cg%3E%3Ctitle%3ELayer 1%3C/title%3E%3Cellipse ry='241' rx='240' id='svg_2' cy='255' cx='252' fill='%23ffffff'/%3E%3Cpath transform='rotate(0.718491 249 267)' stroke='null' id='svg_1' d='m93.65801,276.86639c-5.67695,-0.30832 -10.06368,-4.9332 -9.80564,-10.35971l0.25804,-4.9332c3.03201,-57.78007 52.89884,-103.10382 113.40996,-103.10382l138.31112,0l-37.02919,-32.18911c-4.1932,-3.63823 -4.51576,-9.92806 -0.70962,-13.93628s10.38624,-4.31655 14.57944,-0.67831l56.76949,49.33197c2.12886,1.84995 3.35456,4.50154 3.35456,7.27647s-1.2257,5.42652 -3.35456,7.27647l-56.76949,49.33197c-4.1932,3.63823 -10.7733,3.39157 -14.57944,-0.67831s-3.54809,-10.29805 0.70962,-13.93628l37.02919,-32.06578l-138.31112,0c-49.47977,0 -90.3151,37.12231 -92.76651,84.35767l-0.25804,4.9332c-0.25804,5.42652 -5.16086,9.61973 -10.83781,9.37307zm310.68394,-19.73279c5.67695,0.24666 10.06368,4.9332 9.80564,10.35971l-0.25804,4.9332c-3.03201,57.78007 -52.89884,103.10382 -113.40996,103.10382l-138.31112,0l37.02919,32.18911c4.1932,3.63823 4.51576,9.92806 0.70962,13.93628s-10.38624,4.31655 -14.57944,0.67831l-56.76949,-49.33197c-2.12886,-1.84995 -3.35456,-4.50154 -3.35456,-7.27647s1.2257,-5.42652 3.35456,-7.27647l56.76949,-49.33197c4.1932,-3.63823 10.7733,-3.39157 14.57944,0.67831s3.54809,10.29805 -0.70962,13.93628l-37.02919,32.06578l138.31112,0c49.47977,0 90.3151,-37.12231 92.76651,-84.35767l0.25804,-4.9332c0.25804,-5.42652 5.16086,-9.61973 10.83781,-9.37307z' fill='currentColor'/%3E%3Cpath id='svg_3' d='m456,164' opacity='NaN' stroke='null' fill='currentColor'/%3E%3C/g%3E%3C/svg%3E";
    let cropImgIcon = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='512' height='512' x='0' y='0' viewBox='0 0 41 41' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''%3E%3Cg%3E%3Ccircle cx='20.5' cy='20.5' r='20' fill='%23ffffff' transform='rotate(-22.48 20.495 20.477)' opacity='1' data-original='%23ffffff' class=''%3E%3C/circle%3E%3Cpath fill='%23ffffff' d='M20.5 38.8C9.7 38.8 1 30.3.5 19.6v.8c0 11 9 20 20 20s20-9 20-20v-.8c-.5 10.7-9.2 19.2-20 19.2z' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath fill='%23ffffff' d='M31 25.7h-2.6V14.4c0-.8-.7-1.5-1.5-1.5H15.6v-2.6c0-.8-.7-1.5-1.5-1.5s-1.5.7-1.5 1.5v2.6H10c-.8 0-1.5.7-1.5 1.5s.7 1.5 1.5 1.5h2.6v11.2c0 .8.7 1.5 1.5 1.5h11.2v2.6c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5v-2.6H31c.8 0 1.5-.7 1.5-1.5s-.7-1.4-1.5-1.4zm-15.4 0V16h9.7v9.7z' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath fill='%23......' d='M31 23.7h-2.6V12.4c0-.8-.7-1.5-1.5-1.5H15.6V8.3c0-.8-.7-1.5-1.5-1.5s-1.5.7-1.5 1.5v2.6H10c-.8 0-1.5.7-1.5 1.5s.7 1.5 1.5 1.5h2.6v11.2c0 .8.7 1.5 1.5 1.5h11.2v2.6c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5v-2.6H31c.8 0 1.5-.7 1.5-1.5s-.7-1.4-1.5-1.4zm-15.4 0V14h9.7v9.7z' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3C/g%3E%3C/svg%3E";

    $("#btn_continue_step_2").removeClass("disabled");

    var data = e.target.id;
    var imag = document.getElementById(data);
    if (!imag) {
        console.log('Image element not found for ID:', data);
        return;
    }
    var droppedObject = new fabric.Image(imag, {
        left: 100,
        top: 100,
        hasRotatingPoint: true,
        lockRotation: false,
    });

    var minScaleSize = 300; // Set the minimum size as needed
    var minScaleFactor = Math.min(minScaleSize / droppedObject.width, minScaleSize / droppedObject.height);
    // imageCoordinates['decoration_items'][e.target.attributes.unique_id.value]['size'] = {"width": minScaleSize / droppedObject.width, "height": minScaleSize / droppedObject.height};
    // imageCoordinates['decoration_items'][e.target.attributes.unique_id.value]['pos'] = {"x": droppedObject.top, "y": droppedObject.left};
    // imageCoordinates['decoration_items'][e.target.attributes.unique_id.value]['rotation'] = 0;
    // imageCoordinates['decoration_items'][e.target.attributes.unique_id.value]['isHorizontalFlip'] = false;
    // imageCoordinates['decoration_items'][e.target.attributes.unique_id.value]['isVerticalFlip'] = false;
    droppedObject.scale(minScaleFactor);

    handleObjectMovement(droppedObject, mainImage, e.target.attributes.unique_id.value);
    // handleObjectResizing(droppedObject, mainImage);

    paintingCollageStag.add(droppedObject);
    collegeToRenderImages.push(droppedObject);
    imageData = document.createElement('img');
    imageData.src = deleteIcon;

    var cloneImg = document.createElement('img');
    cloneImg.src = cloneIcon;

    var inverseHorizontalImg = document.createElement('img');
    inverseHorizontalImg.src = inverseHorizontalIcon;

    var inverseVerticalImg = document.createElement('img');
    inverseVerticalImg.src = inverseVerticalIcon;

    var cropImg = document.createElement('img');
    cropImg.src = cropImgIcon;
    fabric.Object.prototype.transparentCorners = false;
    fabric.Object.prototype.cornerColor = 'blue';
    fabric.Object.prototype.cornerStyle = 'circle';
    fabric.Object.prototype.controls.deleteControl = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 20,
        cursorStyle: 'pointer',
        mouseUpHandler: deleteCurrentObject,
        render: renderIcon(imageData),
        cornerSize: 20
    });

    fabric.Object.prototype.controls.clone = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 50,
        cursorStyle: 'pointer',
        mouseUpHandler: cloneObject,
        render: renderIcon(cloneImg),
        cornerSize: 20
    });

    fabric.Object.prototype.controls.inverseHorizontal = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 80,
        cursorStyle: 'pointer',
        mouseUpHandler: handleInverseTransformation,
        render: renderIcon(inverseHorizontalImg),
        cornerSize: 20
    });

    fabric.Object.prototype.controls.inverseVertical = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 110,
        cursorStyle: 'pointer',
        mouseUpHandler: handleInverseTransformation,
        render: renderIcon(inverseVerticalImg),
        cornerSize: 20
    });

    fabric.Object.prototype.controls.crop = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 140,
        cursorStyle: 'pointer',
        mouseUpHandler: prepareCrop,
        render: renderIcon(cropImg),
        cornerSize: 20
    });

    // if (imag && imag.complete) {
    //     imag.onload();
    // }
}

function DragElementOnCanvasCollageToRander(e){
    e.preventDefault();
    if(mainImage === null){
        alert("Main image is missing, Please upload the main image");
        return false;
    }
	// create a rect object
    var deleteIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3E%3Csvg version='1.1' id='Ebene_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='595.275px' height='595.275px' viewBox='200 215 230 470' xml:space='preserve'%3E%3Ccircle style='fill:%23F44336;' cx='299.76' cy='439.067' r='218.516'/%3E%3Cg%3E%3Crect x='267.162' y='307.978' transform='matrix(0.7071 -0.7071 0.7071 0.7071 -222.6202 340.6915)' style='fill:white;' width='65.545' height='262.18'/%3E%3Crect x='266.988' y='308.153' transform='matrix(0.7071 0.7071 -0.7071 0.7071 398.3889 -83.3116)' style='fill:white;' width='65.544' height='262.179'/%3E%3C/g%3E%3C/svg%3E";
    var cloneIcon = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='512' height='512' x='0' y='0' viewBox='0 0 1.693 1.693' style='enable-background:new 0 0 512 512' xml:space='preserve' fill-rule='evenodd' class=''%3E%3Cg%3E%3Ccircle cx='.847' cy='.847' r='.847' fill='%23ffffff' opacity='1' data-original='%23ffffff' class=''%3E%3C/circle%3E%3Cg fill='%23fff'%3E%3Cpath d='m1.183.258.116.116.052.052.116.11v.113A.044.044 0 0 1 1.454.64L1.291.485 1.239.434 1.123.318a.042.042 0 0 1 0-.06.042.042 0 0 1 .06 0z' fill='%23000000' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath fill-rule='nonzero' d='M.626.246h.53a.035.035 0 0 1 .035.038V.52h.24c.02 0 .036.016.036.035v.592a.082.082 0 0 1-.022.056.076.076 0 0 1-.056.024H.626a.076.076 0 0 1-.055-.024.082.082 0 0 1-.022-.056V.326C.549.305.557.285.57.27A.076.076 0 0 1 .626.246zm.478.087h-.46c-.002 0-.004 0-.005.002a.012.012 0 0 0-.003.008v.788c0 .003.001.006.003.008a.006.006 0 0 0 .004.002h.73l.004-.002a.012.012 0 0 0 .003-.008V.608h-.216a.06.06 0 0 1-.06-.06z' fill='%23000000' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath fill-rule='nonzero' d='M.406.448h.151v.087H.422L.418.537a.012.012 0 0 0-.003.009v.787c0 .004.001.007.003.009a.006.006 0 0 0 .004.002h.73l.004-.002a.012.012 0 0 0 .003-.009v-.12h.087v.137a.082.082 0 0 1-.022.056.076.076 0 0 1-.055.025H.406a.076.076 0 0 1-.056-.025.082.082 0 0 1-.022-.056V.53C.328.507.336.487.35.473A.076.076 0 0 1 .406.448z' fill='%23000000' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath d='M.736.395h.268c.023 0 .042.019.042.042 0 .023-.019.042-.042.042H.736A.042.042 0 0 1 .694.437c0-.023.019-.042.042-.042zM.736.543h.268c.023 0 .042.019.042.042 0 .023-.019.042-.042.042H.736A.042.042 0 0 1 .694.585c0-.023.019-.042.042-.042zM.736.69h.541c.023 0 .042.02.042.043 0 .023-.02.042-.042.042H.736A.042.042 0 0 1 .694.733C.694.71.713.691.736.691zM.736.839H1.156c.023 0 .042.019.042.042 0 .023-.02.043-.042.043H.736A.042.042 0 0 1 .694.88C.694.858.713.84.736.84z' fill='%23000000' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3C/g%3E%3C/g%3E%3C/svg%3E";
    var inverseHorizontalIcon = "data:image/svg+xml,%3Csvg width='512' height='512' xmlns='http://www.w3.org/2000/svg' color='black' role='img' class='svg-inline--fa fa-arrows-repeat ' data-icon='arrows-repeat' data-prefix='fal' focusable='false' aria-hidden='true'%3E%3Cg%3E%3Ctitle%3ELayer 1%3C/title%3E%3Cellipse ry='241' rx='240' id='svg_2' cy='255' cx='252' fill='%23ffffff'/%3E%3Cpath transform='rotate(0.718491 249 267)' stroke='null' id='svg_1' d='m93.65801,276.86639c-5.67695,-0.30832 -10.06368,-4.9332 -9.80564,-10.35971l0.25804,-4.9332c3.03201,-57.78007 52.89884,-103.10382 113.40996,-103.10382l138.31112,0l-37.02919,-32.18911c-4.1932,-3.63823 -4.51576,-9.92806 -0.70962,-13.93628s10.38624,-4.31655 14.57944,-0.67831l56.76949,49.33197c2.12886,1.84995 3.35456,4.50154 3.35456,7.27647s-1.2257,5.42652 -3.35456,7.27647l-56.76949,49.33197c-4.1932,3.63823 -10.7733,3.39157 -14.57944,-0.67831s-3.54809,-10.29805 0.70962,-13.93628l37.02919,-32.06578l-138.31112,0c-49.47977,0 -90.3151,37.12231 -92.76651,84.35767l-0.25804,4.9332c-0.25804,5.42652 -5.16086,9.61973 -10.83781,9.37307zm310.68394,-19.73279c5.67695,0.24666 10.06368,4.9332 9.80564,10.35971l-0.25804,4.9332c-3.03201,57.78007 -52.89884,103.10382 -113.40996,103.10382l-138.31112,0l37.02919,32.18911c4.1932,3.63823 4.51576,9.92806 0.70962,13.93628s-10.38624,4.31655 -14.57944,0.67831l-56.76949,-49.33197c-2.12886,-1.84995 -3.35456,-4.50154 -3.35456,-7.27647s1.2257,-5.42652 3.35456,-7.27647l56.76949,-49.33197c4.1932,-3.63823 10.7733,-3.39157 14.57944,0.67831s3.54809,10.29805 -0.70962,13.93628l-37.02919,32.06578l138.31112,0c49.47977,0 90.3151,-37.12231 92.76651,-84.35767l0.25804,-4.9332c0.25804,-5.42652 5.16086,-9.61973 10.83781,-9.37307z' fill='currentColor'/%3E%3Cpath id='svg_3' d='m456,164' opacity='NaN' stroke='null' fill='currentColor'/%3E%3C/g%3E%3C/svg%3E";
    var inverseVerticalIcon = "data:image/svg+xml,%3Csvg width='512' height='512' xmlns='http://www.w3.org/2000/svg' color='black' role='img' class='svg-inline--fa fa-arrows-repeat ' style='transform: rotate(90deg);' data-icon='arrows-repeat' data-prefix='fal' focusable='false' aria-hidden='true'%3E%3Cg%3E%3Ctitle%3ELayer 1%3C/title%3E%3Cellipse ry='241' rx='240' id='svg_2' cy='255' cx='252' fill='%23ffffff'/%3E%3Cpath transform='rotate(0.718491 249 267)' stroke='null' id='svg_1' d='m93.65801,276.86639c-5.67695,-0.30832 -10.06368,-4.9332 -9.80564,-10.35971l0.25804,-4.9332c3.03201,-57.78007 52.89884,-103.10382 113.40996,-103.10382l138.31112,0l-37.02919,-32.18911c-4.1932,-3.63823 -4.51576,-9.92806 -0.70962,-13.93628s10.38624,-4.31655 14.57944,-0.67831l56.76949,49.33197c2.12886,1.84995 3.35456,4.50154 3.35456,7.27647s-1.2257,5.42652 -3.35456,7.27647l-56.76949,49.33197c-4.1932,3.63823 -10.7733,3.39157 -14.57944,-0.67831s-3.54809,-10.29805 0.70962,-13.93628l37.02919,-32.06578l-138.31112,0c-49.47977,0 -90.3151,37.12231 -92.76651,84.35767l-0.25804,4.9332c-0.25804,5.42652 -5.16086,9.61973 -10.83781,9.37307zm310.68394,-19.73279c5.67695,0.24666 10.06368,4.9332 9.80564,10.35971l-0.25804,4.9332c-3.03201,57.78007 -52.89884,103.10382 -113.40996,103.10382l-138.31112,0l37.02919,32.18911c4.1932,3.63823 4.51576,9.92806 0.70962,13.93628s-10.38624,4.31655 -14.57944,0.67831l-56.76949,-49.33197c-2.12886,-1.84995 -3.35456,-4.50154 -3.35456,-7.27647s1.2257,-5.42652 3.35456,-7.27647l56.76949,-49.33197c4.1932,-3.63823 10.7733,-3.39157 14.57944,0.67831s3.54809,10.29805 -0.70962,13.93628l-37.02919,32.06578l138.31112,0c49.47977,0 90.3151,-37.12231 92.76651,-84.35767l0.25804,-4.9332c0.25804,-5.42652 5.16086,-9.61973 10.83781,-9.37307z' fill='currentColor'/%3E%3Cpath id='svg_3' d='m456,164' opacity='NaN' stroke='null' fill='currentColor'/%3E%3C/g%3E%3C/svg%3E";
    let cropImgIcon = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='512' height='512' x='0' y='0' viewBox='0 0 41 41' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''%3E%3Cg%3E%3Ccircle cx='20.5' cy='20.5' r='20' fill='%23ffffff' transform='rotate(-22.48 20.495 20.477)' opacity='1' data-original='%23ffffff' class=''%3E%3C/circle%3E%3Cpath fill='%23ffffff' d='M20.5 38.8C9.7 38.8 1 30.3.5 19.6v.8c0 11 9 20 20 20s20-9 20-20v-.8c-.5 10.7-9.2 19.2-20 19.2z' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath fill='%23ffffff' d='M31 25.7h-2.6V14.4c0-.8-.7-1.5-1.5-1.5H15.6v-2.6c0-.8-.7-1.5-1.5-1.5s-1.5.7-1.5 1.5v2.6H10c-.8 0-1.5.7-1.5 1.5s.7 1.5 1.5 1.5h2.6v11.2c0 .8.7 1.5 1.5 1.5h11.2v2.6c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5v-2.6H31c.8 0 1.5-.7 1.5-1.5s-.7-1.4-1.5-1.4zm-15.4 0V16h9.7v9.7z' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3Cpath fill='%23......' d='M31 23.7h-2.6V12.4c0-.8-.7-1.5-1.5-1.5H15.6V8.3c0-.8-.7-1.5-1.5-1.5s-1.5.7-1.5 1.5v2.6H10c-.8 0-1.5.7-1.5 1.5s.7 1.5 1.5 1.5h2.6v11.2c0 .8.7 1.5 1.5 1.5h11.2v2.6c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5v-2.6H31c.8 0 1.5-.7 1.5-1.5s-.7-1.4-1.5-1.4zm-15.4 0V14h9.7v9.7z' opacity='1' data-original='%23000000' class=''%3E%3C/path%3E%3C/g%3E%3C/svg%3E";
    var data = e.dataTransfer.getData("id");
    if(data == ""){
        return false;
    }
    let unique_id = $("#"+data).attr('unique_id');
    var imag = document.getElementById(data);

    var droppedObject = new fabric.Image(imag, {
        left: e.layerX - 80,
        top: e.layerY - 40,
        hasRotatingPoint: true,
        lockRotation: false,
    });


    var minScaleSize = 300; // Set the minimum size as needed
    var minScaleFactor = Math.min(minScaleSize / droppedObject.width, minScaleSize / droppedObject.height);

    // imageCoordinates['decoration_items'][unique_id]['size'] = {"width": minScaleSize / droppedObject.width, "height": minScaleSize / droppedObject.height};
    // imageCoordinates['decoration_items'][unique_id]['pos'] = {"x": droppedObject.top, "y": droppedObject.left};
    // imageCoordinates['decoration_items'][unique_id]['rotation'] = 0;
    // imageCoordinates['decoration_items'][unique_id]['isHorizontalFlip'] = false;
    // imageCoordinates['decoration_items'][unique_id]['isVerticalFlip'] = false;
    // imageCoordinates['decoration_items'].push({ unique_id: {"width": minScaleSize / droppedObject.width, "height": minScaleSize / droppedObject.height} } );
    // imageCoordinates['decoration_items'].push({ unique_id: { "pos" : {"x": droppedObject.top, "y": droppedObject.left} } });
    // imageCoordinates['decoration_items'].push({ unique_id: { "rotation" : 0} } );
    // imageCoordinates['decoration_items'].push({ unique_id: { "isHorizontalFlip" : false} } );
    // imageCoordinates['decoration_items'].push({ unique_id: { "isVerticalFlip" : false} } );


    droppedObject.scale(minScaleFactor);

    handleObjectMovement(droppedObject, mainImage, unique_id);
    paintingCollageStag.add(droppedObject);
    collegeToRenderImages.push(droppedObject);
    imageData = document.createElement('img');
    imageData.src = deleteIcon;

    var cloneImg = document.createElement('img');
    cloneImg.src = cloneIcon;

    var inverseHorizontalImg = document.createElement('img');
    inverseHorizontalImg.src = inverseHorizontalIcon;

    var inverseVerticalImg = document.createElement('img');
    inverseVerticalImg.src = inverseVerticalIcon;

    var cropImg = document.createElement('img');
    cropImg.src = cropImgIcon;
    fabric.Object.prototype.transparentCorners = false;
    fabric.Object.prototype.cornerColor = 'blue';
    fabric.Object.prototype.cornerStyle = 'circle';
    fabric.Object.prototype.controls.deleteControl = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 20,
        cursorStyle: 'pointer',
        mouseUpHandler: deleteCurrentObject,
        render: renderIcon(imageData),
        cornerSize: 20
    });

    fabric.Object.prototype.controls.clone = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 50,
        cursorStyle: 'pointer',
        mouseUpHandler: cloneObject,
        render: renderIcon(cloneImg),
        cornerSize: 20
    });

    fabric.Object.prototype.controls.inverseHorizontal = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 80,
        cursorStyle: 'pointer',
        mouseUpHandler: handleInverseTransformation,
        render: renderIcon(inverseHorizontalImg),
        cornerSize: 20
    });

    fabric.Object.prototype.controls.inverseVertical = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 110,
        cursorStyle: 'pointer',
        mouseUpHandler: handleInverseTransformation,
        render: renderIcon(inverseVerticalImg),
        cornerSize: 20
    });

    fabric.Object.prototype.controls.crop = new fabric.Control({
        x: 0.6,
        y: -0.5,
        offsetY: 140,
        cursorStyle: 'pointer',
        mouseUpHandler: prepareCrop,
        render: renderIcon(cropImg),
        cornerSize: 20
    });
}

function deleteCurrentObject(eventData, transform) {
    var target = transform.target;
    var canvas = target.canvas;
        canvas.remove(target);
    canvas.requestRenderAll();
}

function cloneObject(eventData, transform) {
    var target = transform.target;
    var canvas = target.canvas;
    target.clone(function(cloned) {
      cloned.left += 10;
      cloned.top += 10;
      canvas.add(cloned);
      handleObjectMovement(cloned, mainImage);
    });
}

var tempCanvas = null;
function prepareCrop(eventData, transform){
    var e = transform.target;
    var canvas = e.canvas;
    tempCanvas = e.canvas;
    var i = new fabric.Rect({
      id: "crop-rect",
      top: e.top,
      left: e.left,
      angle: e.angle,
      width: e.getScaledWidth(),
      height: e.getScaledHeight(),
      stroke: "rgb(42, 67, 101)",
      strokeWidth: 2,
      strokeDashArray: [5, 5],
      fill: "rgba(255, 255, 255, 1)",
      globalCompositeOperation: "overlay",
      lockRotation: true,
    });

    var a = new fabric.Rect({
      id: "overlay-rect",
      top: e.top,
      left: e.left,
      angle: e.angle,
      width: e.getScaledWidth(),
      height: e.getScaledHeight(),
      selectable: !1,
      selection: !1,
      fill: "rgba(0, 0, 0, 0.5)",
      lockRotation: true,
    });

    var s = e.cropX,
        o = e.cropY,
        c = e.width,
        l = e.height;
    e.set({
      cropX: null,
      cropY: null,
      left: e.left - s * e.scaleX,
      top: e.top - o * e.scaleY,
      width: e._originalElement.naturalWidth,
      height: e._originalElement.naturalHeight,
      dirty: false
    });
    i.set({
      left: e.left + s * e.scaleX,
      top: e.top + o * e.scaleY,
      width: c * e.scaleX,
      height: l * e.scaleY,
      dirty: false
    });
    a.set({
      left: e.left,
      top: e.top,
      width: e.width * e.scaleX,
      height: e.height * e.scaleY,
      dirty: false
    });
    i.oldScaleX = i.scaleX;
    i.oldScaleY = i.scaleY;

    canvas.add(a),
      canvas.add(i),
      canvas.discardActiveObject(),
      canvas.setActiveObject(i),
      canvas.renderAll(),

      //
      i.on("moving", function () {
      (i.top < e.top || i.left < e.left) &&
        ((i.left = i.left < e.left ? e.left : i.left),
         (i.top = i.top < e.top ? e.top : i.top)),
        (i.top + i.getScaledHeight() > e.top + e.getScaledHeight() ||
         i.left + i.getScaledWidth() > e.left + e.getScaledWidth()) &&
        ((i.top =
          i.top + i.getScaledHeight() > e.top + e.getScaledHeight()
          ? e.top + e.getScaledHeight() - i.getScaledHeight()
          : i.top),
         (i.left =
          i.left + i.getScaledWidth() > e.left + e.getScaledWidth()
          ? e.left + e.getScaledWidth() - i.getScaledWidth()
          : i.left));
    });

    i.on("scaling", function () {

    });

    //
    i.on("deselected", function () {
      cropImage(i, e);
      canvas.remove(a);
    });
  }

  function cropImage(i, e){

    // remove plaeholder
    tempCanvas.remove(i);

    //
    var s = (i.left - e.left) / e.scaleX,
      o = (i.top - e.top) / e.scaleY,
      c = (i.width * i.scaleX) / e.scaleX,
      l = (i.height * i.scaleY) / e.scaleY;

    // crop
    e.set({
      cropX: s,
      cropY: o,
      width: c,
      height: l,
      top: e.top + o * e.scaleY,
      left: e.left + s * e.scaleX,
      selectable: true,
      cropped: 1
    });

    tempCanvas.renderAll();

  }

function handleInverseTransformation(eventData, transform) {
    var target = transform.target;
    var canvas = target.canvas;

    // Determine the direction of reversal based on control type (e.g., 'inverse-horizontal' or 'inverse-vertical')
    var controlType = transform.corner;
    console.log(controlType);
    var isHorizontal = controlType === 'inverseHorizontal';
    var isVertical = controlType === 'inverseVertical';

    // Apply horizontal reversal
    if (isHorizontal) {
        target.set({
            scaleX: target.scaleX * -1 // Reverse the scaleX to flip horizontally
        });
    }
    // Apply vertical reversal
    else if (isVertical) {
        target.set({
            scaleY: target.scaleY * -1 // Reverse the scaleY to flip vertically
        });
    }

    // Update the object's coordinates
    target.setCoords();

    // Request re-rendering of the canvas
    canvas.requestRenderAll();
}

function renderIcon(icon) {
    return function renderIcon(ctx, left, top, styleOverride, fabricObject) {
      var size = this.cornerSize;
      ctx.save();
      ctx.translate(left, top);
      ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
      ctx.drawImage(icon, -size/2, -size/2, size, size);
      ctx.restore();
    }
  }

async function generateRoomComposer(sec,el){
    page = 1;
    getInPaintingGeneratedDesigns();
    const generateDesignBtn = el;
    const spinner = generateDesignBtn.querySelector('span#submit');
    const tabs = document.querySelectorAll('.gs-option-flex a');
    const previousPageButton = document.querySelector('.previous_page');

    disableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);

    var image_type = document.getElementById('input_img_typ').value;
    // var image = document.getElementById('input_image').value;
    var roomType = document.getElementById(`selectedRoomType${sec}`).value;
    var styleType = document.getElementById(`selectedDesignStyle${sec}`).value;
    var modeType = document.getElementById(`selectedModeType${sec}`).value;
    var noOfDesign = 4; // document.getElementById(`no_of_des${sec}`).value;
    var strengthType = document.getElementById(`strength${sec}`).value;

    // if (image == '') {
    //     alert("Make sure you add an Input Image!");
    //     $(el).attr('disabled', false);
    //     return;
    // }

    if (roomType == '') {
        let error_message
        if (sec == 0) {
            error_message = 'Make sure to select Room Type!';
        } else if (sec == 1) {
            error_message = 'Make sure to select House Angle!';
        } else {
            error_message = 'Make sure to select Garden Type!';
        }
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }

    if (styleType == '') {
        let error_message = 'Make sure to select Design Style!';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }

    if (modeType == '') {
        let error_message = 'Make sure to select Mode Type!';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }

    console.log($(".custom_added_elements").length, $(".existing_elements").length)
    // if($(".custom_added_elements").length <= 0 || $(".existing_elements").length <= 0){
    //     alert("Please upload custom elements to proceed.");
    //     return false;
    // }
    var dataPage = document.querySelector('.data_page').getAttribute('data-page');
    $("#submit").css("display","inline-block");
    let mergedImages = mergeImages();
    let mergedMaskedImages = mergeMaskImages();
    console.log(mergedImages.toDataURL(), mergedMaskedImages.toDataURL());
    if(!mergedImages){
        $("#submit").css("display","none");
        return false;
    }

    generationDivLoader(noOfDesign,croppedImage);

    var formData = new FormData();
    var aiAPI = "/runpod/college_to_render";
    formData.append("data", mergedImages.toDataURL());
    // formData.append("dataImages", JSON.stringify(imageCoordinates));
    formData.append("masked_image", mergedMaskedImages.toDataURL());
    formData.append("design_style", styleType);
    formData.append("roomtype", roomType);
    formData.append("prompt_modifier", '');
    formData.append("designtype", 0);
    formData.append("mobilecheck", 0);
    formData.append("eta", 0);
    formData.append("guidance_scale", 7);
    formData.append("negative_prompt", '');
    formData.append("steps", 40);
    formData.append("strengthType", strengthType);
    formData.append("redesign_model", modeType);
    formData.append("modeType", '9');
    formData.append("privateId", 0);
    formData.append("numUserGens", 13);
    formData.append("isSubbed", true);
    formData.append("superenhance", 0);
    formData.append("watermark", false);
    formData.append("image_type", image_type);
    formData.append("is_staging", false);
    formData.append("is_custom_instruction", 0);
    formData.append("custom_instruction", '');
    formData.append("no_of_Design", noOfDesign);
    formData.append("public", 0);
    await fetch(aiAPI, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: "include",
        headers: {
            accept: 'multipart/form-data',
            'Access-Control-Allow-Origin': '*',
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
        },
        crossDomain: true,
        body: formData,
    })
        .then(response => {
            if (response.status == 501) {
                modalStore.style.display = 'block';
            }
            return response.json();
        })
        .then(result => {
            $("#submit").css("display","none");
            enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
            removeLoaderDivs(noOfDesign);
            if (result.error) {
                alert(result.error);
                return;
            } else {
                loadRenders(0);
            }
        })
        .catch(error => {
            enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
            console.error('Error:', error);
        });

    // var progressindicatordiv = document.getElementById(`progressindicatordiv`);
    // progressindicatordiv.remove();

    //$(el).attr('disabled', false);

    // Enable AI category Pill
    //_updateAiCatePillsStatus('enable');
}


function handleObjectMovement(innerObj, mainObj, unique_id = null) {
    innerObj.on('moving', function() {
        // Check if the inner object exceeds the boundaries of the main object
        if (innerObj.left < mainObj.left) {
            innerObj.left = mainObj.left; // Reset the left position if it's outside
        } else if (innerObj.left + innerObj.width * innerObj.scaleX > mainObj.left + mainObj.width * mainObj.scaleX) {
            innerObj.left = mainObj.left + mainObj.width * mainObj.scaleX - innerObj.width * innerObj.scaleX; // Reset the left position if it's outside
        }

        if (innerObj.top < mainObj.top) {
            innerObj.top = mainObj.top; // Reset the top position if it's outside
        } else if (innerObj.top + innerObj.height * innerObj.scaleY > mainObj.top + mainObj.height * mainObj.scaleY) {
            innerObj.top = mainObj.top + mainObj.height * mainObj.scaleY - innerObj.height * innerObj.scaleY; // Reset the top position if it's outside
        }
        if(unique_id != null){
            // imageCoordinates['decoration_items'][unique_id]['pos'] = {"x": innerObj.top, "y": innerObj.left};
            // imageCoordinates['decoration_items'].push({ unique_id: { "pos" : {"x": innerObj.top, "y": innerObj.left} } });

        }
    });

    innerObj.on('scaling', function() {
        // Check if the inner object exceeds the boundaries of the main object
        if (innerObj.left < mainObj.left) {
            innerObj.left = mainObj.left; // Reset the left position if it's outside
        } else if (innerObj.left + innerObj.width * innerObj.scaleX > mainObj.left + mainObj.width * mainObj.scaleX) {
            innerObj.left = mainObj.left + mainObj.width * mainObj.scaleX - innerObj.width * innerObj.scaleX; // Reset the left position if it's outside
        }

        if (innerObj.top < mainObj.top) {
            innerObj.top = mainObj.top; // Reset the top position if it's outside
        } else if (innerObj.top + innerObj.height * innerObj.scaleY > mainObj.top + mainObj.height * mainObj.scaleY) {
            innerObj.top = mainObj.top + mainObj.height * mainObj.scaleY - innerObj.height * innerObj.scaleY; // Reset the top position if it's outside
        }
        if(unique_id != null){
            // imageCoordinates['decoration_items'][unique_id]['pos'] = {"x": innerObj.top, "y": innerObj.left};
            // imageCoordinates['decoration_items'][unique_id]['size'] = {"width": innerObj.width * innerObj.scaleX, "height": innerObj.height * innerObj.scaleY};
            // imageCoordinates['decoration_items'].push({ unique_id: { "pos" : {"x": innerObj.top, "y": innerObj.left} } });
            // imageCoordinates['decoration_items'].push({ unique_id: {'size' : { "width": innerObj.width * innerObj.scaleX, "height": innerObj.height * innerObj.scaleY} } });

        }

    });
}

function handleObjectResizing(innerObj, mainObj, unique_id) {
    innerObj.on('scaling', function() {
        // Calculate the maximum width and height allowed for the inner object
        var maxWidth = mainObj.width * mainObj.scaleX;
        var maxHeight = mainObj.height * mainObj.scaleY;

        // If the inner object's width exceeds the maximum width, constrain it
        if (innerObj.width * innerObj.scaleX > maxWidth) {
            var newScaleX = maxWidth / innerObj.width;
            innerObj.scaleX = newScaleX;
            innerObj.scaleY = newScaleX; // Maintain aspect ratio
            // imageCoordinates['decoration_items'][unique_id]['size'] = {"width": newScaleX};
        }

        // If the inner object's height exceeds the maximum height, constrain it
        if (innerObj.height * innerObj.scaleY > maxHeight) {
            var newScaleY = maxHeight / innerObj.height;
            innerObj.scaleY = newScaleY;
            innerObj.scaleX = newScaleY; // Maintain aspect ratio
            // imageCoordinates['decoration_items'][unique_id]['size'] = {"height": newScaleY};
        }
    });
}

function createInverseIcon(options) {
    var size = options.size || 24; // Set the size of the icon (default: 24)
    var path = options.path || "M3 12h18M12 3l6 9-6 9"; // Set the path of the icon (default: a double arrow)
    var color = options.color || "black"; // Set the color of the icon (default: black)

    return new fabric.Path(path, {
        fill: 'none',
        stroke: color,
        strokeWidth: 2,
        strokeLinecap: 'round',
        strokeLinejoin: 'round',
        selectable: false,
        evented: false,
        width: size,
        height: size
    });
}

function generateUniqueId(prefix = 'image_id') {
    const timestamp = Date.now(); // Current timestamp in milliseconds
    const randomNum = Math.floor(Math.random() * 100000); // Random number between 0 and 99999
    return `${prefix}_${timestamp}_${randomNum}`;
}
