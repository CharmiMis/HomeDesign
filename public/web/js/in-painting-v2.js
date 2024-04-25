const fileInput = document.querySelector("#ipFilePicker");
const inPaintStageContainer = document.querySelector('#inpainting-stag-outer');
const virtualStagDesignContainer = document.querySelector('#virtualStagDesignContainer');
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
var dataPage = document.querySelector('.data_page').getAttribute('data-page');
async function loadImageCropper() {
    hasTransparentPixels = false;
    const [file] = fileInput.files;
    var image = '';
    image = await toBase64(file);
    if (dataPage == 'aiObjectRemoval' || dataPage == 'segmentPage' || dataPage == 'change-colors-texture' || dataPage == 'inPaint' || dataPage == 'fillSpace') {
        ipsValidateImage(file, () => {
            clearPaintingStag();
            loadImageToStage(image.result);
            croppedImage = image.result;
        }, (error) => {
            ipsFailOnValidImage(error, min_height_width = 768);
            fileInput.value = '';
        }, 768);
    }
    else if( dataPage == 'sky-color'){
        ipsValidateImage(file, () => {
            clearNonMaskPaintingStag();
            loadImageToStage(image.result);
            croppedImage = image.result;
        }, (error) => {
            ipsFailOnValidImage(error, min_height_width = 768);
            fileInput.value = '';
        }, 768);
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
            ipsFailOnValidImage(error, min_height_width = 768);
            fileInput.value = '';
        }, 768);
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
    var routeURL = document.getElementById('routeToGetBase64Image').getAttribute('data-route');
    croppedImage = $(this).data('img');
    if(dataPage == 'sky-color'){
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


var lastLin, imageLayer, brushLayer, blackLayer;
const paintingStag = new Konva.Stage({
    container: 'painting-stag',
    width: paintingStagOriginalWidth,
    height: paintingStagOriginalHeight,
});

// generateDesignBtn.addEventListener('click', (e) => {
//     e.preventDefault();
//
// });
async function _generateInPaintingDesign(sec, el) {
    generateInPainting(sec);
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
                console.log(response.data);
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
    if(sizeElement){
        sizeElement.oninput = (e) => {
            size = e.target.value;
            $("#ip-brush-thickness-text").html(size);
        };
    }

    $("#inUploadBtn").on('click', function () {
        $("#ipFilePicker").trigger('click');
    });
    $("#inUploadBtnOnModal").on('click', function () {
        $("#ipFilePicker").trigger('click');
    });

    $("#ip-clearImage").on('click', function () {
        maskingCheckbox.checked = true;
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
});

function addImageLayer() {
    imageLayer = new Konva.Layer();
    paintingStag.add(imageLayer);
}
var lastLine;
function addBrushLayer() {
    if (hasTransparentPixels || dataPage == 'sky-color') {
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

    if (cursorCheckbox && cursorCheckbox.checked) {
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
            cursorCircle.style.border = maskingCheckbox.checked ? '1px solid rgb(245, 244, 248)' : '1px solid rgb(199, 20, 20)';
        } else {
            cursorCircle.style.display = 'none'; // Hide the cursor
        }

        if (!isBrushing) {
            return;
        }
        e.evt.preventDefault();
        if (maskingCheckbox.checked && isBrushing) {
            var newPoints = lastLine.points().concat([pos.x, pos.y]);
            lastLine.points(newPoints);
        }

        if (!maskingCheckbox.checked && isBrushing) {
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
        if (maskingCheckbox.checked) {
            // In masking mode
            if(cursorCheckbox.checked){
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
            maskingCheckbox.disabled = false;
        } else {
            // In remove masking mode
            if(cursorCheckbox.checked){
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
        maskingCheckbox.disabled = true;
        maskingCheckbox.checked = true;
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
        // if (!hasTransparentPixels && dataPage != 'aiObjectRemoval' && dataPage != 'sky-color') {
        //     showLoader(); // Show loader when starting the fetch
        //     getNpyImgFile(image);
        // }
    };
    imageObj.src = image;
    imageLayer.draw();
    blackLayer.draw();
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

async function generateInPainting(sec) {
    const generateDesignBtn = document.querySelector(`#generateDesignBtn${sec}`);

    generateDesignBtn.disabled = true;
    generateDesignBtn.getElementsByTagName('span')[0].style.display = 'inline-block';

    await callInPaintingAPI(sec);

    // generateDesignBtn.disabled = false;
    // generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
}

async function callInPaintingAPI(sec) {
    const generateDesignBtn = document.querySelector(`#generateDesignBtn${sec}`);
    $('.full_hd_quality').addClass('disable-btn');
    $('.edit-as-fill-space').addClass('disable-btn');
    $('.precision-ultra-enhancer').addClass('disable-btn');
    projectButton.disabled = true;
    deleteButton.disabled = true;

    var mode = modeValue.value;
    var noOfDesign = document.getElementById(`no_of_design${sec}`).value;

    if (!imageLayer.hasChildren()) {
        alert('Upload image');
        generateDesignBtn.disabled = false;
        generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
        return;
    }
    if (!hasTransparentPixels && dataPage != 'sky-color') {
        if (!brushLayer.hasChildren()) {
            alert('Mask image.');
            generateDesignBtn.disabled = false;
            generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
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
    var masked_base64 = await getMaskedImages();
    // Disable AI category Pill
    _updateAiCatePillsStatus('disable');

    // var base64_base_string = original_base64.split(',')[1];

    // var base64_mask_string = masked_base64.split(',')[1];

    var superenhance = 0;
    var isSubbed = false;

    // var numUserGens = updatedUsage.data.count;
    // isSubbed = !updatedUsage.data.watermark;
    // var watermark = updatedUsage.data.watermark;
    var segmentType = segmentation ? segmentation : 'false';
    const promptInput = document.querySelector(`#promptInput${sec}`);
    const promptInputDesign = document.querySelector(`#promptInputDesign${sec}`);
    const promptInputRoomType = document.querySelector(`#promptInputRoomType${sec}`);
    const promptSkyWeather = document.querySelector(`#weather${sec}`);

    const prompColorTexture = document.querySelector(`#color_texture${sec}`);
    const prompMaterialTypeTexture = document.querySelector(`#material_type${sec}`);

    var prompt = promptInput ? promptInput.value : "";
    var designStyle = promptInputDesign ? promptInputDesign.value : "" ;
    var roomType = promptInputRoomType ? promptInputRoomType.value : "" ;
    var isTransparent = hasTransparentPixels;

    var checkboxMaskingLabelString = checkboxMaskingLabel.join(', ');
    var color = prompColorTexture ? prompColorTexture.value : "";
    var material_type = prompMaterialTypeTexture ? prompMaterialTypeTexture.value : "" ;
    var skyWeather = promptSkyWeather ? promptSkyWeather.value : "" ;
    if(color != "" || material_type != ""){
        prompt = "";
    }
    var formData = new FormData();
    if (dataPage == 'aiObjectRemoval' || dataPage == 'segmentPage') {
        // var inPaintUrl = `${GPU_SERVER_HOST}/img2img?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&modeType=${mode}&is_staging=${is_staging}&segmentType=${segmentType}`;
        var inPaintUrl = "/runpod/furniture_removal";
        formData.append("isSubbed", isSubbed);
        formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        formData.append("is_transparent", isTransparent);
        formData.append("segmentType", segmentType);
        formData.append("runpod_name", runpodName);
    } else if (dataPage == 'change-colors-texture') {
        // var inPaintUrl = `${GPU_SERVER_HOST_SEG}/change_color?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&modeType=${mode}&is_transparent=${isTransparent}&is_staging=${is_staging}&segmentType=${segmentType}&objects=${checkboxMaskingLabelString}&color=${color}&material=${material_type}`;
        var inPaintUrl = "/runpod/color-and-texture";
        formData.append("isSubbed", isSubbed);
        formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        formData.append("is_transparent", isTransparent);
        formData.append("segmentType", segmentType);
        formData.append("objects", checkboxMaskingLabelString);
        formData.append("color", color);
        formData.append("material", material_type);
    } else if (dataPage == 'sky-color') {
        // var inPaintUrl = `${GPU_SERVER_HOST_SEG}/sky_color_change?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&is_staging=${is_staging}&weather=${skyWeather}&modeType=${mode}`;
        var inPaintUrl = "/runpod/sky-color-change";
        formData.append("isSubbed", isSubbed);
        formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        formData.append("weather", skyWeather);
    } else if (dataPage == 'decorstaging') {
        // var inPaintUrl = `${GPU_SERVER_HOST_SEG}/sky_color_change?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&is_staging=${is_staging}&weather=${skyWeather}&modeType=${mode}`;
        var inPaintUrl = "/runpod/decor_staging";
        formData.append("isSubbed", isSubbed);
        formData.append("roomtype", roomType);
        formData.append("design_style", designStyle);
        formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        formData.append("is_transparent", isTransparent);
        formData.append("segmentType", segmentType);
        formData.append("runpod_name", runpodName);
    } else if (dataPage == 'fillSpace' || dataPage == 'inPaint') {
        // var inPaintUrl = `${GPU_SERVER_HOST_SEG}/sky_color_change?isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&is_staging=${is_staging}&weather=${skyWeather}&modeType=${mode}`;
        if(dataPage == 'inPaint'){
            var inPaintUrl = "/runpod/precision";
        }else if(dataPage == 'fillSpace'){
            var inPaintUrl = "/runpod/fill_space";
        }
        formData.append("isSubbed", isSubbed);
        formData.append("roomtype", roomType);
        formData.append("design_style", designStyle);
        formData.append("superenhance", superenhance);
        formData.append("no_of_Design", noOfDesign);
        formData.append("designtype", sec);
        formData.append("modeType", mode);
        formData.append("is_transparent", isTransparent);
        formData.append("segmentType", segmentType);
        formData.append("runpod_name", runpodName);
    }
    // else {
    //     // var inPaintUrl = `${GPU_SERVER_HOST}/img2img?roomtype=${roomType}&design_style=${designStyle}&isSubbed=${isSubbed}&superenhance=${superenhance}&no_of_Design=${noOfDesign}&designtype=${sec}&modeType=${mode}&is_transparent=${isTransparent}&is_staging=${is_staging}&segmentType=${segmentType}`;
    //     var inPaintUrl = "/runpod/img2img";

    //     formData.append("isSubbed", isSubbed);
    //     formData.append("roomtype", roomType);
    //     formData.append("design_style", designStyle);
    //     formData.append("superenhance", superenhance);
    //     formData.append("no_of_Design", noOfDesign);
    //     formData.append("designtype", sec);
    //     formData.append("modeType", mode);
    //     formData.append("is_transparent", isTransparent);
    //     formData.append("is_staging", is_staging);
    //     formData.append("segmentType", segmentType);

    // }
    // formData.append("fireid", user.uid);
    // formData.append("init_images", original_base64);
    // formData.append("mask", masked_base64);
    // formData.append("prompt", prompt);
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
                success: function (resp) {
                    generatedImageList = resp['Sucess'];
                    generateDesignBtn.disabled = false;
                    generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
                    $('.full_hd_quality').removeClass('disable-btn');
                    $('.edit-as-fill-space').removeClass('disable-btn');
                    $('.precision-ultra-enhancer').removeClass('disable-btn');
                    projectButton.disabled = false;
                    deleteButton.disabled = false;
                    // Iterate over the list of images
                    generatedImageList.forEach(image => {
                        var design = {
                            generated_image : image,
                            design_style: designStyle,
                            room_type: roomType,
                        }
                        var itemHtml = generatedImageItem(design);
                        var data = document.getElementById(`virtualStagDesignContainer`);
                        data.insertBefore(itemHtml, data.firstChild);
                    });
                    setTimeout(function () {
                        $('html, body').animate({
                            scrollTop: virtualStagDesignContainer.offsetTop
                        }, 100);
                    }, 500);
                    // Enable AI category Pill
                    _updateAiCatePillsStatus('enable');
                },
                error: function (resp) {
                    swal("Something Went Wrong!", {
                        icon: "error",
                    });
                }
            });
        }else{
            generatedImageList = JSON.parse(result)['Sucess'];
            generateDesignBtn.disabled = false;
            generateDesignBtn.getElementsByTagName('span')[0].style.display = 'none';
            $('.full_hd_quality').removeClass('disable-btn');
            $('.edit-as-fill-space').removeClass('disable-btn');
            $('.precision-ultra-enhancer').removeClass('disable-btn');
            projectButton.disabled = false;
            deleteButton.disabled = false;
            // Iterate over the list of images
            generatedImageList.forEach(image => {
                var design = {
                    generated_image : image,
                    design_style: designStyle,
                    room_type: roomType,
                }
                var itemHtml = generatedImageItem(design);
                var data = document.getElementById(`virtualStagDesignContainer`);
                data.insertBefore(itemHtml, data.firstChild);
            });
            setTimeout(function () {
                $('html, body').animate({
                    scrollTop: virtualStagDesignContainer.offsetTop
                }, 100);
            }, 500);
            // Enable AI category Pill
            _updateAiCatePillsStatus('enable');
        }
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

function generatedImageItem(item) {
    var temp = document.getElementById("inPaintingCard");
    var clone = temp.content.cloneNode(true);
    var img = clone.querySelector('[data-item="image"]');
    var downloadBtn = clone.querySelector('[data-item="download-btn"]');
    var previewBtn = clone.querySelector('[data-item="preview-btn"]');
    var useAsInput = clone.querySelector('[data-item="user_as_input"]');
    var styleSpan = clone.querySelector('.render-overlay-box .render-overlay:nth-child(1)');
    var roomTypeSpan = clone.querySelector('.render-overlay-box .render-overlay:nth-child(2)');

    // downloadBtn.href = item.generated_image;
    downloadBtn.dataset.downloadUrl = item.generated_image;
    previewBtn.dataset.img = item.generated_image;
    useAsInput.dataset.img = item.generated_image;
    img.src = item.generated_image;
    if (item.design_style !== undefined && item.design_style !== '' && item.design_style != 'N/A') {
        styleSpan.textContent = "Style: " + item.design_style;
    }
    if (item.room_type !== undefined && item.room_type !== '' && item.design_style != 'N/A') {
        roomTypeSpan.textContent = "Room Type: " + item.room_type;
    }
    return clone;
}
// function previewImage() {
//     $("#modalImagePreview").modal('show');
//     var src = $('.inpainting-preview').data('img');
//     $("#mip").attr('src', src);
// }
// $('.inpainting-preview').on('click',function(){
// })
$(document).on('click', '.inpainting-preview', function () {
    $("#modalImagePreview").modal('show');
    var src = $(this).data('img');
    $("#mip").attr('src', src);
});
$(document).on('click', '.full_hd_quality', async function () {
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

    var updatedUsage = await verifyPlan();

    if ((!updatedUsage) || !updatedUsage.status) {
        _showUsageMessage(updatedUsage);
        $(el).attr('disabled', false);
        return;
    }

    $('.painting_generating_bt').addClass('disable-btn');
    $('.full_hd_quality').addClass('disable-btn');
    $('.edit-as-fill-space').addClass('disable-btn');
    $('.precision-ultra-enhancer').addClass('disable-btn');
    projectButton.disabled = true;
    deleteButton.disabled = true;

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
                deleteButton.disabled = false;
                $("#progressindicatordiv").remove();
            }else{
                var formData = new FormData();
                formData.append("privateId", resp.data.privateId);
                formData.append("roomtype", resp.data.room_type);
                formData.append("design_style", resp.data.style);
                formData.append("modeType", mode);
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
                        $('.painting_generating_bt').removeClass('disable-btn');
                        $('.full_hd_quality').removeClass('disable-btn');
                        $('.edit-as-fill-space').removeClass('disable-btn');
                        $('.precision-ultra-enhancer').removeClass('disable-btn');
                        projectButton.disabled = false;
                        deleteButton.disabled = false;
                        var image = result['Sucess']['generated_image'][0];
                        var design = {
                            generated_image : image,
                            design_style: resp.data.style,
                            room_type: resp.data.room_type,
                            hd_image : true,
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
                        deleteButton.disabled = false;

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
let get_designs = {
    url: SITE_BASE_URL + 'in-painting-designs',
    inpainting: modeValue.value,
}

var page = 1;
$(document).on('click', '.page-link', function () {
    page = $(this).attr('data-url').split('=').pop();
    getInPaintingGeneratedDesigns();
});

function getInPaintingGeneratedDesigns() {
    var response = null;
    // let paintingDesignUrl = $('#getInPaintingDesigns').data('url');
    $.ajax({
        url: get_designs.url,
        data: {
            inpainting: get_designs.inpainting,
            page: page,
            designType : get_designs.design_type,
        },
        async: false,
        beforeSend: function () {

        },
        success: function (resp) {
            $('#virtualStagDesignContainer').html('');
            $('#virtualStagDesignContainer').html(resp.data);
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
    // imageCropper.replace(b64image);
    // $("#cropImageModal").modal('show');
    clearPaintingStag();
    croppedImage = b64image;
    loadImageToStage(b64image);
    sessionStorage.removeItem('b64image');
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

    const generateDesignBtn = document.querySelector(`#generateDesignBtn0`);

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
    var embededImgFile = `/runpod/getMasking?width=${sizes.width}&height=${sizes.height}`;

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

        var ulElement = $('<ul>', { class: 'ks-cboxtags' });

        segmentationInfo.forEach(function (result) {
            var label = result.label;
            var checkboxId = result.id;

            var liElement = $('<li>');
            var checkbox = $('<input>', { type: 'checkbox', id: checkboxId, name: 'checkbox', value: checkboxId, class: 'checkbox' });
            var labelElement = $('<label>', { for: checkboxId, text: label });

            liElement.append(checkbox).append(labelElement);
            ulElement.append(liElement);
        });
        $('.chkbox-segment').append(ulElement);

        $('.checkbox').change(function () {
            var labelText = $(this).next('label').text();
            // Check if the checkbox is checked
            if ($(this).is(':checked')) {
                ids.push(Number($(this).val()))
                checkboxMaskingLabel.push(labelText);
                loadImage(ids,segmentationValues)
            } else {
                // Remove the label text from the array
                var indexToRemove = checkboxMaskingLabel.indexOf(labelText);
                if (indexToRemove !== -1) {
                    checkboxMaskingLabel.splice(indexToRemove, 1);
                }

                let valueToDelete = Number($(this).val());
                // Creating a new array without the specified value
                ids = ids.filter(item => item !== valueToDelete);
                loadImage(ids,segmentationValues)
            }
             // Update brushing visibility based on checkbox state
            // toggleBrushingVisibility(isBrushingEnabled);
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
            maskingCheckbox.disabled = false;
            $("#ip-clearImage").prop('disabled', false);
            $("#ip-clearImage").css('cursor', 'pointer');
        }else{
            segmentation = false;
            maskingCheckbox.disabled = true;
            maskingCheckbox.checked = true;
            if(currentActionIndex > 0){
                $("#ip-clearImage").prop('disabled', false);
                $("#ip-clearImage").css('cursor', 'pointer');
            }
            else{
                $("#ip-clearImage").prop('disabled', true);
                $("#ip-clearImage").css('cursor', 'not-allowed');
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
    $('.inpainting-stag-outer').css('filter', 'blur(0)'); // Clear blur effect
    // $('.inpainting-stag-loader').hide(); // Hide loader
    $("#loadToStagLoader").modal('hide');
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
    if (cursorCheckbox.checked) {
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

    var updatedUsage = await verifyPlan();

    if ((!updatedUsage) || !updatedUsage.status) {
        _showUsageMessage(updatedUsage);
        $(el).attr('disabled', false);
        return;
    }

    $('.painting_generating_bt').addClass('disable-btn');
    $('.full_hd_quality').addClass('disable-btn');
    $('.edit-as-fill-space').addClass('disable-btn');
    $('.precision-ultra-enhancer').addClass('disable-btn');
    projectButton.disabled = true;
    deleteButton.disabled = true;

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
                deleteButton.disabled = false;
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
                        deleteButton.disabled = false;
                        var image = result['Sucess']['generated_image'][0];
                        var design = {
                            generated_image : image,
                            design_style: resp.data.style,
                            room_type: resp.data.room_type,
                        }
                        var itemHtml = generatedImageItem(design);
                        console.log('itemHtml',itemHtml);
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
                        deleteButton.disabled = false;

                        console.error('Error:', error);
                    });
            }
        },
        error: function (resp) {
            data = resp.responseJSON;
        }
    })
});

