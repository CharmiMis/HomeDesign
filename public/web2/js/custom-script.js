// const { preview } = require("vite");
const objectContainer = document.querySelector(".key-objects-result");
const projectButton = document.querySelector('.add_to_project_btn');
const deleteButton = document.querySelector('.delete_button');
var dataPage = document.querySelector('.data_page').getAttribute('data-page');
const selectedImages = {};
var runpodName = 'first_runpod';
var runpodType = '1';
$("._home_login_submit").click(function () {

    handleLogin("#loginModelForm", function (resp) {
        if (resp.status) {
            window.location = '';
        }
    }, function (resp) {
        var respData = resp.responseJSON;
        if (respData.status == false) {
            $.each(respData.errors, function (key, val) {

                $("#loginModelForm").find('[name="' + key + '"]').next('.error-block').html(val[0]);

            });
        }
    })
})

function handleLogin(form, onSuccess, onerror) {
    $(form).ajaxSubmit({
        beforeSend: function () {
            $(form).find('.error-block').html('');
            $(form).find('._disable_on_submit').prop('disabled', true);
        },
        complete: function () {
            $(form).find('._disable_on_submit').prop('disabled', false);
        },
        success: function (resp) {
            onSuccess(resp);
        },
        error: function (resp) {
            onerror(resp);
        }
    });
}


async function ckAddSubscriber(post_data) {

    var url = SITE_BASE_URL + 'convertkit/add_subscriber.php'
    var data = null;
    $.ajax({
        url: url,
        type: "POST",
        data: post_data,
        async: false,
        success: function (resp) {
            data = resp;
        },
        error: function (resp) {
            data = false;
        }
    })


    return data;
};


async function ckAddIfNewGoogleUser(result) {

    if (result.additionalUserInfo.isNewUser) {

        var ckPayload = {
            email: result.user.email,
            name: result.user.displayName,
            plan: 'free_plan'
        }

        return ckAddSubscriber(ckPayload);
    }

    return 'Old User';
}

async function verifyPlan() {

    var data = null;

    var url = SITE_BASE_URL + 'verify-plan';
    $.ajax({
        url: url,
        type: "POST",
        async: false,
        success: function (resp) {
            data = resp;
        },
        error: function (resp) {
            data = resp.responseJSON;
        }
    })

    return data;

}

$(".logout_user").click(function () {
    // if (confirm("Are you sure you want to logout?") == true) {
    // window.indexedDB.deleteDatabase('fileDatabase');
    //     $("#logoutForm").submit();
    // }

})
$(".btnUpgNowPopup").click(function () {
    $("#modalIndividualLimit").modal('hide');
    if ($("#buy").length) {
        $('html, body').animate({
            scrollTop: $("#buy").offset().top
        }, 100);
    } else {
        window.location = $(this).data('href');
    }
})

$('select').change(function (e) {
    var className = $(this).find('option:selected').attr('class');
    if (className == "paid_feature_modal") {
        $(this).find('option:not(.paid_feature_modal):eq(0)').prop('selected', true);
        $('#view_all_interior_room_type').modal('hide');
        $('#view_all_interior_choose_design').modal('hide');
        $('#view_all_garden_type').modal('hide');
        $("#modalUpgradePlan").modal('show');
        return false;
    } else if (className == "paid_style_feature_modal") {
        $(this).find('option:not(.paid_style_feature_modal):eq(0)').prop('selected', true);
        $('#view_all_interior_room_type').modal('hide');
        $('#view_all_interior_choose_design').modal('hide');
        $('#view_all_garden_type').modal('hide');
        $("#modalStyleUpgradePlan").modal('show');
        return false;
    } else if (className == "paid_roomtype_feature_modal") {
        $(this).find('option:not(.paid_roomtype_feature_modal):eq(0)').prop('selected', true);
        $('#view_all_interior_room_type').modal('hide');
        $('#view_all_interior_choose_design').modal('hide');
        $('#view_all_garden_type').modal('hide');
        $("#modalRoomTypeUpgradePlan").modal('show');
        return false;
    }
})

$(".paid_feature_modal").click(function () {
    $('#view_all_interior_room_type').modal('hide');
    $('#view_all_interior_choose_design').modal('hide');
    $('#view_all_garden_type').modal('hide');
    $('#gs_ai_tools').modal('hide');
    $("#modalUpgradePlan").modal('show');
})
$(".paid_style_feature_modal").click(function () {
    $('#view_all_interior_room_type').modal('hide');
    $('#view_all_interior_choose_design').modal('hide');
    $('#view_all_garden_type').modal('hide');
    $("#modalStyleUpgradePlan").modal('show');
})
$(".paid_roomtype_feature_modal").click(function () {
    $('#view_all_interior_room_type').modal('hide');
    $('#view_all_interior_choose_design').modal('hide');
    $('#view_all_garden_type').modal('hide');
    $("#modalRoomTypeUpgradePlan").modal('show');
})
$(".api_buy_modal").click(function () {
    $("#apiUpgradeModal").modal('show');
})

$('form').submit(function () {
    $(this).find('._disable_on_submit').prop('disabled', true);
});

function createDesignItem(data, showButton = null) {
    // if (showButton == null) {
    //     showButton = (activeplan != 'free' && activeplan != '');
    // }
    showButton = true;
    isSelected = true;
    isShowUseAsInput = data.show_data;
    enhanceButton = true;
    showHdButton = true;
    precisionUpUser = data.precisionUserValue;
    showDelBtn = false;
    isFavoriteVisible = true;
    favoriteImage = data.favorite;
    hdImage = data.hd_image;
    showFavoriteBtn = false;
    showHDIcon = false;
    if (data.private == 1) {
        showDelBtn = false;
        showFavoriteBtn = false;
        showHDIcon = false;
    } else {
        showDelBtn = true;
        showFavoriteBtn = true;
        showHDIcon = true;
    }
    var leftSide = _createDesignItemBox(data.id, data.original_url, ['Before'], showButton, enhanceButton == false, isShowUseAsInput, isSelected = false, showHdButton = false, data.section, showDelBtn, precisionUpUser, isFavoriteVisible = false, showFavoriteBtn, favoriteImage, showHDIcon = false, hdImage);
    var rightOL = [
        'After',
        'Style: ' + data.style,
    ]

    var mode = [];

    if (data.room_type != null && data.room_type != '') {
        rightOL.push(`Room Type: ${data.room_type}`);
    }
    if (data.mode != null && data.mode != '') {
        rightOL.push(`Mode: ${data.mode}`);
        mode = data.mode;
    }
    var rightSide = _createDesignItemBox(data.id, data.generated_url, rightOL, showButton, enhanceButton == true, isShowUseAsInput, isSelected = true, showHdButton = true, data.section, showDelBtn, precisionUpUser, isFavoriteVisible = true, showFavoriteBtn, favoriteImage, showHDIcon = true, hdImage, mode);

    var html = `<div class="row mb-2">
                    <div class="col-md-6 col-sm-6">
                        ${leftSide}
                    </div>
                    <div class="col-md-6 col-sm-6">
                        ${rightSide}
                    </div>
                </div>`;
    return html;
}

function _createDesignItemBox(id = null, imageUrl, styles = [], canDownload = true, enhanceButton, isShowUseAsInput, isSelected, showHdButton, section, showDelBtn, precisionUpUser, isFavoriteVisible, showFavoriteBtn, favoriteImage, showHDIcon = false, hdImage, mode = null) {

    var image = `<img class="rendered-img" src="${imageUrl}" alt="" loading="lazy">`;
    var icons = '';
    if (canDownload) {
        icons = `<div class="downld-bx">
					<div class="sharetab sharetab-buttons share text-center" onclick="previewImage('${imageUrl}')" title="Open">
                        <img src="/web/images/magnifying1.svg" alt="" loading="lazy">
						<span>Show</span>
                    </div>
                    <a class="sharetab sharetab-buttons download" href="javascript:void(0)" data-download-url="${imageUrl}" title="Download" download>
                        <img src="/web/images/download1-hover.svg" alt="" loading="lazy">
						<span>Download</span>
                    </a>

                    `;
        if (isShowUseAsInput == true) {
            icons += `<a class="sharetab sharetab-buttons use-as-input" data-img="${imageUrl}" href="javascript:void(0)" title="Use as Input">
						<img src="/web/images/input1.svg" alt="" loading="lazy">
						<span>Input</span>
					</a>`;
            // if (enhanceButton == true) {
            //     if (precisionUpUser == 'true') {
            //         icons += `<a class="sharetab sharetab-buttons ultra-enhancerbtn" onclick="showUpdateModal()" data-img="${imageUrl}" data-sec="${section}" href="javascript:void(0)" title="Ultra Enhancer">
            // 						<img src="/web/images/enhance1.svg" alt="" loading="lazy">
            // 						<span>Enhance</span>
            // 					</a>`;
            //     } else {
            //         icons += `<a class="sharetab  sharetab-buttons ultra-enhancer" onclick="ultraEnhancer(this)" data-img="${imageUrl}" data-sec="${section}" href="javascript:void(0)" title="Ultra Enhancer">
            // 						<img src="/web/images/enhance1.svg" alt="" loading="lazy">
            // 						<span>Enhance</span>
            // 					</a>`;
            //     }
            // }
            if (showHdButton == true) {
                if (precisionUpUser == 'true') {
                    icons += `<div class="sharetab sharetab-buttons full_hd_quality share text-center" onclick="showUpdateModal()" data-img="${imageUrl}" data-sec="${section}" title="Full Hd Quality">
									<img src="/web/images/hd1.svg">
									<span>HD</span>
								</div>`;
                    icons += `<div class="sharetab sharetab-buttons precision_btn share text-center" onclick="showUpdateModal()" data-img="${imageUrl}" data-sec="${section}" title="Precision+">
                                <img src="/web/images/in-painting-icon.png">
                                <span>Precision+</span>
                                </div>`;
                } else {
                    if (hdImage == 0) {
                        icons += `<div class="sharetab sharetab-buttons full_hd_quality generate_hd_img share text-center" data-img="${imageUrl}" data-sec="${section}" title="Full Hd Quality">
									<img src="/web/images/hd1.svg">
									<span>HD</span>
								</div>`;
                    }
                    icons += `<div class="sharetab sharetab-buttons precision_btn edit_with_precision share text-center" data-img="${imageUrl}" data-sec="${section}" title="Precision+">
                                <img src="/web/images/in-painting-icon.png">
                                <span>Precision+</span>
                                </div>`;
                }
                // icons += `<div class="sharetab sharetab-buttons gogl_search_btn search_with_google share text-center" data-img="${imageUrl}" data-sec="${section}" title="Google Search">
                //                 <img src="/web/images/magnifying1.svg" alt="" loading="lazy">
                //                 <span style="margin-left: 11px;">Search</span>
                //                 </div>`;
                icons += `<div class="sharetab sharetab-buttons feedback_btn share text-center showFeedbackModal" data-img="${imageUrl}" data-id="${id}" data-sec="${section}" title="Feedback" design_type="${mode}">
                    <img loading="lazy" src="/web/images/feedback.png">
                    <span>Feedback</span>
                </div>`;
            }
        }
        icons += `</div>`;

        // Check if isSelected is true
        if (isSelected == true) {
            if (showDelBtn == true) {
                // var selectImage = `<div class="chkimg imgcheck">
                //                 <input type="checkbox" class="ml_dw_img" onclick="getMultipleImages('${imageUrl}')"/>
                //             </div>`;

                var selectImage = `<div class="checkbox-animate">
                                        <label>
                                            <input type="checkbox" name="check" class="ml_dw_img" onclick="getMultipleImages('${imageUrl}')">
                                            <span class="input-check"></span>
                                        </label>
                                    </div>`;
            }
        }

        if (isFavoriteVisible == true) {
            if (showFavoriteBtn == true) {
                var favoriteImage = `<div class="favcheck">
                                        <img width="23" height="23" class="favcheckimg favoriteImage${imageUrl}" src="${favoriteImage ? '/web/images/red_heart.png' : '/web/images/white_heart.png'}" onclick="addRemovefavorite('${imageUrl}')">
                                    </div>`;
            }
        }
        if (showHDIcon == true) {
            if (hdImage == 1) {
                var hdImage = `<div class="hd_image_div">
                <img width="40" height="35" class="hd_image" src="/web/images/hd_icon.png">
                                    </div>`;
            }
        }
    }

    var stylesHtml = `<div class="render-overlay-box">`;
    for (i = 0; i < styles.length; i++) {
        stylesHtml += `<span class="render-overlay">${styles[i]}</span>`;
    }
    stylesHtml += `</div>`;

    var html = `<div class="render-img-bx fadeIn">
                    ${image}
                    ${icons}
					${selectImage !== undefined ? selectImage : '&nbsp;'}
					${favoriteImage !== undefined ? favoriteImage : '&nbsp;'}
					${hdImage !== undefined ? hdImage : '&nbsp;'}
                    ${stylesHtml}
                </div>`;
    return html;
}

$(".cls_menu.menu-link").click(function () {
    closeNav();
})

$(".img-upload-outer").on('dragenter dragover dragleave drop', function (e) {
    e.preventDefault()
    e.stopPropagation()
});

$("body").on('click', '.use-as-input', async function () {
    var image_url = $(this).data('img');
    var sec = $(this).data('sec');

    $(".gs-option-flex li").removeClass("active");
    $(".gs-option-flex li").eq(sec).addClass("active");

    $('#input_img_typ').val('blob');
    $('#input_image').val(image_url);

    $('#loading_brilliance').modal('show');

    let gallery = document.getElementById(`gallery0`);
    gallery.style.display = 'block';

    let img = document.createElement('img');
    img.src = image_url;
    document.getElementById(`gallery0`).removeChild(document.getElementById(`gallery0`).firstElementChild);
    document.getElementById(`gallery0`).appendChild(img);
    document.getElementById(`viewImage`).scrollIntoView();

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
        if (dataPage == 'redesign' || dataPage == 'productSearch' || dataPage == 'sky-color' || dataPage == 'rostMyHome') {
            $('.redesign-designs-tabs').css('display', 'none');
            $("#loading_brilliance").modal('hide');
        }
    }, 2000)
});

function attachFilesToInput(sec, files) {

    var fileInput = document.getElementById(`fileselect${sec}`);
    fileInput.files = files;
    fileInput.dispatchEvent(new Event('change'));
}

/** Code to handle image when user drop start*/
var imageUploader = document.getElementsByClassName('img-upload-outer');
$.each(imageUploader, function (index, item) {
    item.addEventListener('drop', (ev) => {
        ev.preventDefault();
        if (user == null) {
            showLoginModal();
            return;
        } else {
            var sec_id = item.dataset.section;
            var fileInput = document.getElementById(`fileselect${sec_id}`);
            fileInput.files = ev.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        }

    })
});
/** Code to handle image when user drop end*/
var clickedDiv;
var iUnderstanClickCount = 0;
// Display the modal when the div is clicked
$(".ai-upload-image").on('click', function (event) {
    clickedDiv = $(this);
    if (user.is_show_guideline_modal == 0) {
        $('#uploading_instruction').modal('show');
    } else {
        var fileInput = clickedDiv.find('input[type="file"]');
        fileInput.trigger('click');
     }
});

$(".dimg-picker, #ipFilePicker, #ipFilePicker2").on("click", function(event){
    event.stopPropagation();
});

// When the "I Understand" button inside the modal is clicked
$(".gs-modal-best-inderstand").on('click', function () {
    clickCount++;
    if (clickedDiv) {
        var fileInput = clickedDiv.find('input[type="file"]');
        fileInput.trigger('click');
    }

    if (clickCount > 2) {
        $.ajax({
            url: '/update-modal-flag', // Change this to your actual endpoint URL
            type: 'POST',
            data: {
                is_show_guideline_modal: 1
            },
            success: function(response) {
            },
            error: function(xhr, status, error) {
                console.error('Error updating modal flag:', error);
            }
        });
    }
});

// When the "Don’t show this again" button inside the modal is clicked
$(".gs-modal-dont-show-modal").on('click', function () {
    // Find the file input within the same .ai-upload-image container and trigger the click event
    if (clickedDiv) {
        var fileInput = clickedDiv.find('input[type="file"]');
        fileInput.trigger('click');
    }

    $.ajax({
        url: '/update-modal-flag', // Change this to your actual endpoint URL
        type: 'POST',
        data: {
            is_show_guideline_modal: 1
        },
        success: function(response) {
        },
        error: function(xhr, status, error) {
            console.error('Error updating modal flag:', error);
        }
    });
});

// Existing file input change event handler
$(".dimg-picker").on('change', function (e) {
    var filePicker = $(this);
    var files = filePicker[0].files;
    var section = filePicker.data('section');

    ipsValidateImage(files[0], () => {
        ipsPreviewImg(section);
    }, (error) => {
        ipsFailOnValidImage(error);
        filePicker.val('');
        $("#gallery" + section).hide();
        $(".drop-cont" + section).removeAttr("style");
        $('#input_img_typ').val('');
        $('#input_image').val('');
    });
});

$(".img-upload-outer").on('click touchstart', function () {
    var target = 'fileselect' + $(this).data('section');
    document.getElementById(target).click();
});


function ipsFailOnValidImage(error, min_height_width = 512) {
    if (error == 'type') {
        let error_message = 'Allowed Extensions are: jpeg, jpg and png.';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
    }

    if (error == 'size') {
        let error_message = 'Minimum size should be ' + min_height_width + 'x' + min_height_width;
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
    }
}
$(".dash_mobile_menu").click(function () {
    $('.dash-menus').addClass('screen-left-active');
});
$(".dash-menu-close").click(function () {
    $('.dash-menus').removeClass('screen-left-active');
});

$('body').on('click', '.st-b-ug-plan', function () {
    goToBuySection();
});

function goToBuySection() {
    var target = $('#buy');
    if (target.length) {
        $('html,body').animate({
            scrollTop: target.offset().top
        }, 100);
    } else {
        window.location = SITE_BASE_URL + "#buy";
    }
}



function ipsPreviewImg(section) {
    // $('#uploading_instruction').modal('show');
    $('#uploading_instruction').modal('hide');
    $('#loading_brilliance').modal('show');
    var file = $("#fileselect" + section)[0].files[0];

    let gallery = document.getElementById(`gallery${section}`);
    gallery.style.display = 'block';

    // let uploadText = document.getElementById(`uploadText${section}`);
    // uploadText.style.display = 'none';

    // document.getElementsByClassName(`drop-cont${section}`)[0].style.visibility = 'hidden';

    let reader = new FileReader()
    reader.readAsDataURL(file)
    reader.onloadend = function () {
        let img = document.createElement('img')
        img.src = reader.result
        document.getElementById(`gallery${section}`).removeChild(document.getElementById(`gallery${section}`).firstElementChild);
        document.getElementById(`gallery${section}`).appendChild(img);
        $('#input_img_typ').val('blob');
        $('#input_image').val(reader.result);

        let furnitureFinderImg = document.querySelector('.gs-similar-product-img');
        if (furnitureFinderImg) {
            furnitureFinderImg.src = reader.result;
        }
    }
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
        if (dataPage == 'redesign' || dataPage == 'productSearch' || dataPage == 'sky-color' || dataPage == 'rostMyHome' || dataPage == 'convenient-redesign') {
            $('.redesign-designs-tabs').css('display', 'none');
            $("#loading_brilliance").modal('hide');
        }
    }, 2000)
}

const ipsValidateImage = (file, success, fail, min_height_width = 512) => {

    var allowedFileType = ['image/jpeg', 'image/png'];
    let fileTypeValid = allowedFileType.some((fileType) => fileType === file.type);

    if (!fileTypeValid) {
        return fail('type');
    }
    var img = new Image();
    var oUrl = window.URL.createObjectURL(file);

    img.src = oUrl;

    var isValidDimension = false;

    return new Promise(res => {
        img.onload = function (resp) {
            var width = img.naturalWidth;
            var height = img.naturalHeight;
            window.URL.revokeObjectURL(img.src);

            isValidDimension = (width >= min_height_width && height >= min_height_width);
            if (!isValidDimension) {
                return fail('size');
            }
            return success();
        };
    });
};

const ipsValidateTextureImage = (file, success, fail) => {

    var allowedFileType = ['image/jpeg', 'image/png'];
    let fileTypeValid = allowedFileType.some((fileType) => fileType === file.type);

    if (!fileTypeValid) {
        return fail('type');
    }
    var img = new Image();
    var oUrl = window.URL.createObjectURL(file);

    img.src = oUrl;

    var isValidDimension = false;

    return new Promise(res => {
        img.onload = function (resp) {
            var width = img.naturalWidth;
            var height = img.naturalHeight;
            window.URL.revokeObjectURL(img.src);

            return success();
        };
    });
};

function updateFastSpring(userDetail = null) {

    if (user) {
        fastspring.builder.recognize({
            "email": user.email,
        });
    }
}

function previewImage(beforeSrc,afterSrc) {
    $("#modalImagePreview").modal('show')
    $("#mip_before").attr('src', beforeSrc);
    $("#mip_after").attr('src', afterSrc);
}
//get multiple images in array
var multipleDownloadImg = [];

function getMultipleImages(id) {
    if ($('.ml_dw_img').is(':checked') && !this.multipleDownloadImg.includes(id)) {
        this.multipleDownloadImg.push(id);
    } else {
        this.multipleDownloadImg.splice(this.multipleDownloadImg.indexOf(id), 1);
    }
    if (this.multipleDownloadImg.length > 0) {
        $('.ai-upload-latest-top').css('display', 'flex');
        $(`.delete_favourite_buttons`).removeClass('hidden');
        // $(`.delete_button`).removeClass('hidden');
        // $(`.download_button`).removeClass('hidden');
        // $(`.remove_image_from_folder_btn`).removeClass('hidden');
    } else {
        $('.ai-upload-latest-top').css('display', 'none');
        $(`.delete_favourite_buttons`).addClass('hidden');
        // $(`.delete_button`).addClass('hidden');
        // $(`.download_button`).addClass('hidden');
        // $(`.remove_image_from_folder_btn`).addClass('hidden');
    }
}
//delete multiple images
function deleteMultipleImages() {
    $("#confirm_modal").modal('show');
}

// Event listener for the confirmation button in the modal
$(".yes-confirm-modal").on('click', function() {
    var jsonData = JSON.stringify(this.multipleDownloadImg);
    var route = $('#deleteRenderImages').data('route');
    $.ajax({
        url: route,
        type: "POST",
        data: {
            ids: multipleDownloadImg
        },
        success: function (response) {
            $("#confirm_delete_modal").modal('show');
            if(dataPage != 'favourite'){
                if(dataPage == 'redesign' || dataPage == 'convenient-redesign'){
                    getRedesignGeneratedDesigns();
                }else{
                    getInPaintingGeneratedDesigns();
                }
            }
            multipleDownloadImg.forEach(function(id) {
                $(`.ai-upload-latest-single[data-image-id="${id}"]`).remove();
            });
            multipleDownloadImg = [];
            $(`.delete_favourite_buttons`).addClass('hidden');
            $('#jumphere0').css('display', 'none');
        },
        error: function (xhr, status, error) {
            var error = error.responseJSON;
            Swal.fire(
                'Oops!',
                error.message,
                'warning'
            );
        }
    });

    // Hide the modal after confirmation
    $("#confirm_modal").modal('hide');
});

$(".close-confirm-modal").on('click', function() {
    $("#confirm_modal").modal('hide');
});

$(".close-confirm-delete-modal").on('click', function() {
    $("#confirm_delete_modal").modal('hide');
});

$(".close-confirm-project-modal").on('click', function() {
    $("#addToprojectmodal").modal('hide');
    $("#success_project_modal").modal('hide');
});

//download zip for multiple render
function downloadMultipleImages() {
    var zip = new JSZip();

    // Generate a directory within the Zip file structure
    var img = zip.folder("gallery_images");

    // Add a file to the directory, in this case an image with data URI as contents
    $.each(this.multipleDownloadImg, function (i, item) {
        var image = item;

        var promise = downloadFile(image);
        img.file("image" + [i] + ".png", promise);
    });
    // Generate the zip file asynchronously
    zip.generateAsync({
        type: "blob"
    })
        .then(function (content) {
            // Force down of the Zip file
            saveAs(content, "archive.zip");
        });
}

function saveAs(blob, filename) {
    if (typeof navigator.msSaveOrOpenBlob !== 'undefined') {
        return navigator.msSaveOrOpenBlob(blob, fileName);
    } else if (typeof navigator.msSaveBlob !== 'undefined') {
        return navigator.msSaveBlob(blob, fileName);
    } else {
        var elem = window.document.createElement('a');
        elem.href = window.URL.createObjectURL(blob);
        elem.download = filename;
        elem.style = 'display:none;opacity:0;color:transparent;';
        (document.body || document.documentElement).appendChild(elem);
        if (typeof elem.click === 'function') {
            elem.click();
        } else {
            elem.target = '_blank';
            elem.dispatchEvent(new MouseEvent('click', {
                view: window,
                bubbles: true,
                cancelable: true
            }));
        }
        URL.revokeObjectURL(elem.href);
    }
}

function downloadFile(url) {
    // or a global Promise if you expect it to exist, see http://caniuse.com/#feat=promises
    return new JSZip.external.Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.responseType = 'blob';
        xhr.onload = function () {
            // you should handle non "200 OK" responses as a failure with reject
            resolve(xhr.response);
        };
        // you should handle failures too
        xhr.open('GET', url);
        xhr.send();
    });
}
//end download zip for multiple render

$("[data-hide='true']").on('click', function () {
    var target = $(this).data('target');
    $(target).hide();
})

function closeCustomModal(modal) {
    $("#modalImagePreview").show();
}

function noGeneration() {
    return `<div style="text-align:center; margin-left: 37px;margin-top: 237px;margin-bottom: 437px;"><p style="font-size: 20px; color: white">No Generations 😥😥</p></div>`
}

function _updateAiCatePillsStatus(status) {

    if (status == 'disable') {
        $("#ai-category-pills").find('button.nav-link:not(.active)').addClass('ai-pill-disabled').attr('disabled', true);
    } else {
        $("#ai-category-pills").find('button.nav-link:not(.active)').removeClass('ai-pill-disabled').attr('disabled', false);
    }

}

let get_designs_config = {
    url: SITE_BASE_URL + 'get-designs',
    page: 1,
    type: 'public',
    isLoading: false
}

function publicRenderError(sec) {
    var code = noGeneration();
    const fragment = document.createElement('div');
    fragment.innerHTML = code;
    document.getElementById(`all_data${sec}`).appendChild(fragment);
}

var page = 1;
// $(document).on('click', '.page-link', function () {
//     page = $(this).attr('data-url').split('=').pop();
//     getGeneratedDesigns('gallery');
// });

$(document).on('click', '.page-link', function () {
    page = $(this).attr('data-url').split('=').pop();
    getGeneratedDesigns('favorites');
    page = 1;
});

function getGeneratedDesigns(type) {
    if (get_designs_config.isLoading || get_designs_config.url == null || get_designs_config.page == null) {
        return false;
    }
    if (type == 'favorites') {
        page = page;
    } else {
        page = get_designs_config.page;
    }
    var response = null;
    $.ajax({
        url: get_designs_config.url,
        data: {
            page: page,
            type: get_designs_config.type,
            pageType: type,
            designType: get_designs_config.design_type
        },
        async: false,
        beforeSend: function () {
            get_designs_config.isLoading = true;
        },
        success: function (resp) {
            if (resp.pageType == 'favorites') {
                $('#favorite_image_data').html('');
                $('#favorite_image_data').html(resp.data);
            } else {
                response = resp;
                get_designs_config.page = resp.data.next_page;
            }
        },
        error: function (error) { },
        complete: function () {
            get_designs_config.isLoading = false;
        }
    });

    return response;
}

const getBase64FromUrl = async (url) => {

    return new Promise((resolve) => {
        $.ajax({
            url: SITE_BASE_URL + "get-encoded-file",
            async: false,
            data: {
                image_url: url
            },
            success: function (resp) {
                resolve(resp);
            },
            error: function (resp) {
                var json = resp.responseJSON;
                resolve(json);
            }
        })
    });
}

var generationCount = 0;

async function _generateDesign(sec, el) {
    page = 1;
    getRedesignGeneratedDesigns();
    const generateDesignBtn = el;
    const spinner = generateDesignBtn.querySelector('span#submit');
    const tabs = document.querySelectorAll('.gs-option-flex a');
    const previousPageButton = document.querySelector('.previous_page');

    disableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
    if (localStorage.getItem('filekey' + sec) !== undefined) {
        localStorage.removeItem('filekey' + sec);
        localStorage.removeItem('oldDetails');
    }
    var precisionUserValue = document.getElementById('precisionUser').value;
    var newGenerationCount = generationCount + 1;
    generationCount = newGenerationCount;
    if (newGenerationCount == 7) {
        $("#multipleGenaerationModal").modal('show');
    }

    $(el).attr('disabled', true);
    $('.gs-continue-btn').addClass('disable-btn');
    $('.on-gen-disable').addClass('disable-btn');
    var etaValue = 0.0;
    var cgsValue = 7.0;
    var negativeValue = "";
    var stepsValue = 40;

    var image_type = document.getElementById('input_img_typ').value;
    var image = document.getElementById('input_image').value;
    const promptRoomType = document.querySelector(`#selectedRoomType${sec}`);
    const promptStyleType = document.querySelector(`#selectedDesignStyle${sec}`);
    const promptModeType = document.querySelector(`#selectedModeType${sec}`);
    var roomType = promptRoomType ? promptRoomType.value : "" ;
    var styleType = promptStyleType ? promptStyleType.value : "" ;
    var modeType = promptModeType ? promptModeType.value : "" ;
    var noOfDesign = document.getElementById(`no_of_des${sec}`).value;

    if (image == '') {
        alert("Make sure you add an Input Image!");
        $(el).attr('disabled', false);
        $('.gs-continue-btn').removeClass('disable-btn');
        $('.on-gen-disable').removeClass('disable-btn');
        return;
    }

    if (roomType == '' && dataPage != 'convenient-redesign') {
        let error_message
        if (sec == 0) {
            error_message = 'Oops! You didn’t select the room type.';
        } else if (sec == 1) {
            error_message = 'Oops! You didn’t select the house angle.';
        } else {
            error_message = 'Oops! You didn’t select the garden type.';
        }
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        $(el).attr('disabled', false);
        $('.gs-continue-btn').removeClass('disable-btn');
        $('.on-gen-disable').removeClass('disable-btn');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }

    if (styleType == '' && dataPage != 'convenient-redesign') {
        let error_message = 'Oops! You didn’t select the design style.';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        $(el).attr('disabled', false);
        $('.gs-continue-btn').removeClass('disable-btn');
        $('.on-gen-disable').removeClass('disable-btn');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }

    if(dataPage == 'convenient-redesign'){
        modeType = 'Convenient Redesign';
    }

    if (modeType == '') {
        let error_message = 'Oops! You didn’t select the mode type.';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        $(el).attr('disabled', false);
        $('.gs-continue-btn').removeClass('disable-btn');
        $('.on-gen-disable').removeClass('disable-btn');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }

    var isSubbed = false;

    //ajax code to store the count of styles
    var countStyles = {
        styleType: styleType,
        roomType: roomType,
        sec: sec
    };
    // Disable AI category Pill
    _updateAiCatePillsStatus('disable');

    // document.getElementById(`hundredid${sec}`).click();

    var strengthType = document.getElementById(`strength${sec}`).value;
    var is_staging = (APP_LOCAL == 'production') ? 'false' : 'true';
    var customInstructionData = document.getElementById(`custom_instruction${sec}`).value;

    if (customInstructionData == '' && dataPage == 'convenient-redesign') {
        let error_message = 'Make sure to Add a Prompt!';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        $(el).attr('disabled', false);
        $('.gs-continue-btn').removeClass('disable-btn');
        $('.on-gen-disable').removeClass('disable-btn');
        enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
        return;
    }

    generationDivLoader(noOfDesign,image);
    $('.ai-upload-latest-designs')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });

    document.getElementById(`jumphere0`).scrollIntoView();

    var divElement = document.getElementById(`all_data0`);
    divElement.firstElementChild.scrollIntoView();

    if(dataPage != 'convenient-redesign'){
        var privatize = 0;
        if (document.getElementById(`nwtoggle${sec}`).checked === true) {
            privatize = 1;
        }
    }

    var promptALL = "";
    var mobileCheck = 0;
    if (window.screen.availWidth < 600) {
        mobileCheck = 1;
    } else {
        mobileCheck = 0;
    }

    var superenhance = 0;
    if ($("#ck_full_hd_" + sec).length && $("#ck_full_hd_" + sec).is(':checked') === true) {
        superenhance = 1;
    }

    var formData = new FormData();
    var aiAPI = null;
    if (modeType == 'Creative Redesign' || modeType == 'Fill The Room' || modeType == 'Fill The Garden' || modeType == 'Fill The Exterior') {
        // aiAPI = `${GPU_SERVER_HOST_INIT}/init?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&prompt=${styleType}&roomtype=${roomType}&prompt_modifier=${promptALL}&id=${user.uid}&designtype=${sec}&mobilecheck=${mobileCheck}&eta=${etaValue}&guidance_scale=${cgsValue}&negative_prompt=${negativeValue}&steps=${stepsValue}&strengthType=${strengthType}&modeType=${modeType}&privateId=${privatize}&numUserGens=${numUserGens}&isSubbed=${isSubbed}&public=${privatize}&superenhance=${superenhance}&watermark=${watermark}&image_type=${image_type}&is_staging=${is_staging}&is_custom_instruction=${customInstruction}&custom_instruction=${customInstructionData}&no_of_Design=${noOfDesign}`;

        aiAPI = "/runpod/creative_redesign";
    } else if (modeType == 'Sketch to Render') {
        // aiAPI = `${GPU_SERVER_HOST_INIT}/render_realistic?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&prompt=${styleType}&roomtype=${roomType}&prompt_modifier=${promptALL}&id=${user.uid}&designtype=${sec}&mobilecheck=${mobileCheck}&eta=${etaValue}&guidance_scale=${cgsValue}&negative_prompt=${negativeValue}&steps=${stepsValue}&strengthType=${strengthType}&modeType=${modeType}&privateId=${privatize}&numUserGens=${numUserGens}&isSubbed=${isSubbed}&superenhance=${superenhance}&watermark=${watermark}&image_type=${image_type}&is_staging=${is_staging}&is_custom_instruction=${customInstruction}&custom_instruction=${customInstructionData}&no_of_Design=${noOfDesign}`;

        aiAPI = "/runpod/render_realistic";
    }else if(modeType == 'Convenient Redesign'){
        aiAPI = "/runpod/convenient_redesign";
    } else {
        // aiAPI = `${GPU_SERVER_HOST_INIT}/homedesigns?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&prompt=${styleType}&roomtype=${roomType}&prompt_modifier=${promptALL}&id=${user.uid}&designtype=${sec}&mobilecheck=${mobileCheck}&eta=${etaValue}&guidance_scale=${cgsValue}&negative_prompt=${negativeValue}&steps=${stepsValue}&strengthType=${strengthType}&modeType=${modeType}&privateId=${privatize}&numUserGens=${numUserGens}&isSubbed=${isSubbed}&superenhance=${superenhance}&watermark=${watermark}&image_type=${image_type}&is_staging=${is_staging}&is_custom_instruction=${customInstruction}&custom_instruction=${customInstructionData}&no_of_Design=${noOfDesign}`;
        aiAPI = "/runpod/beautiful_redesign";
    }
    formData.append("data", image);
    formData.append("prompt", styleType);
    formData.append("roomtype", roomType);
    formData.append("designtype", sec);
    formData.append("strengthType", strengthType);
    formData.append("modeType", modeType);
    formData.append("custom_instruction", customInstructionData);
    formData.append("no_of_Design", noOfDesign);
    formData.append("public", privatize);
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
            enableGenerateButton(generateDesignBtn, spinner,tabs,previousPageButton);
            $('.gs-continue-btn').removeClass('disable-btn');
            $('.on-gen-disable').removeClass('disable-btn');

            if (result.error) {
                alert(result.error);
                return;
            }
            generatedImage = result['Sucess']['generated_image'];
            originalImage = result['Sucess']['original_image'];
            let storedIds = result['storedIds'];
            generatedImage.forEach((item, index) => {
                let design = {
                    id: storedIds[index],
                    original_url: originalImage,
                    generated_url: item,
                    style: styleType,
                    room_type: roomType,
                    mode: modeType,
                    show_data: true,
                    section: sec,
                    precisionUserValue: precisionUserValue,
                    private: privatize,
                    hd_image: 0,
                };
                let code = generatedRedesignItem(design);
                 // Add the generated design image to the array
                 removeLoaderDivs(noOfDesign);
                // var progressindicatordiv = document.getElementById(`progressindicatordiv`);
                // progressindicatordiv.remove();
                // $("#progressindicatordiv").remove();
                let data = document.getElementById(`all_data0`);
                // document.getElementById(`progid`).style.display = 'none';

                data.insertBefore(code, data.firstChild);
            });
        })
        .catch(error => {
            // $('.ultra-enhancer').removeClass('disable-btn');
            // $('.full_hd_quality').removeClass('disable-btn');
            // $('._btn_gndeisgn').removeClass('disable-btn');
            // $('.precision_btn').removeClass('disable-btn');
            // projectButton.disabled = false;
            // deleteButton.disabled = false;
            console.error('Error:', error);
        });

        removeLoaderDivs(noOfDesign);

    $(el).attr('disabled', false);

    // Enable AI category Pill
    _updateAiCatePillsStatus('enable');
}

function customInstruction(sec) {
    var isCustomInstruction = document.getElementById(`nwcust${sec}`).checked;
    if (isCustomInstruction == true) {
        $(`#custom_instruction${sec}`).show();
        // $("#customAiModal").modal('show');
    } else {
        $(`#custom_instruction${sec}`).val('').hide();
        // $("#customAiModal").modal('hide');
    }
}

function download(downloadURL) {
    $.ajax({
        url: SITE_BASE_URL + "get-base64",
        data: {
            source: downloadURL
        },
        async: false,
        beforeSend: function () {
            $("#hdaLoaderOuter").addClass('d-flex');
            $("#hdaLoaderOuter").find('.hda-loader-message').html('Downloding Image...');
        },
        complete: function () {
            $("#hdaLoaderOuter").removeClass('d-flex');
        },
        success: function (resp) {
            if (resp.status) {
                var ImageBase64 = resp.data.base64;
                var a = document.createElement("a"); //Create <a>
                a.href = ImageBase64; //Image Base64 Goes here
                a.download = "download.png"; //File name Here
                a.click(); //Downloaded file
            }
        }
    });
}
$('body').on('click', '[data-download-url]', function () {
    var $url = $(this).data('download-url');
    download($url);
});
$('#skip').click(function () {
    $.ajax({
        type: "GET",
        url: SITE_BASE_URL + "closeUserServey",
        success: function (result) {
            $('#serveyModal').modal('hide'); // Close the modal
            location.reload();
        },
        error: function (error) {
            console.log('error', error);
        }
    });
});
var ichecked = $("[name='question[0]']:checked").data('target-variant');
$('#continue').click(function () {
    $('.survey_heading_div').addClass('hidden');
    var welcomeVariantEl = parseInt($(this).attr('welcome-active-variant'));
    var currentVariantEl = $(".welcome_content[welcome-variant='" + welcomeVariantEl + "']");
    currentVariantEl.removeClass('active');
    if (welcomeVariantEl == 2) {
        var firstVariantEl = $(".question_variant[data-variant='0']");
        var firstQuestionEl = $(".question-outer[data-question='1']");

        $('.servey_welcome').hide();
        $('#survey-next-button').show();
        firstVariantEl.addClass('active');
        firstQuestionEl.addClass('active');
        $('form#servey_form').css('padding', '30px 40px');
        $('.questions-footer').show();
        $('.bottom-btn').hide();
    }
    var continueButton = $("#continue");
    continueButton.attr('welcome-active-variant', 2)
    var currentVariantEl = $(".welcome_content[welcome-variant=2]");
    $('#skip').removeClass('hidden');
    currentVariantEl.addClass('active');
    $('.progress-start').val(25);
    var iframe = document.getElementById('welcome_video_frame');
    iframe.parentNode.removeChild(iframe);
});

// function customInstruction(sec) {
//     var isCustomInstruction = document.getElementById(`nwcust${sec}`).checked;
//     if (isCustomInstruction == true) {
//         $(`#custom_instruction${sec}`).show();
//     } else {
//         $(`#custom_instruction${sec}`).val('').hide();
//     }
// }

let progressbarValue = 25;
$("#survey-next-button").click(function () {
    var activeVariantNo = parseInt($(this).attr('data-active-variant'));
    var activeQuestionNo = parseInt($(this).attr('data-active-question'));

    var currentVariantEl = $(".question_variant[data-variant='" + activeVariantNo + "']");
    if (activeVariantNo == 0) {
        var targetVariantNo = $("[name='question[" + activeQuestionNo + "]']:checked").data('target-variant');

        var targetVariant = $(".question_variant[data-variant='" + targetVariantNo + "']");

        if (targetVariantNo == '' || targetVariantNo == undefined || targetVariant.length == 0) {
            //next button should be disabled
            alert("Please select an answer before clicking Next.");
            progressbarValue = progressbarValue;
            $('.progrss-value').val(progressbarValue);
            return false;
        }
        var currentQuestion = $(".question-outer[data-question='" + activeQuestionNo + "']");
        var checkedOptions = currentQuestion.find("input[type='radio']:checked, input[type='checkbox']:checked");
        if (checkedOptions.length === 0) {
            alert("Please select an answer before clicking Next.");
            progressbarValue = progressbarValue;
            $('.progrss-value').val(progressbarValue);
            return false;
        }


        currentVariantEl.removeClass('active');
        targetVariant.addClass('active');
        $('.prev').removeClass('hidden');

        var nextQuestionEl = targetVariant.find('[data-question]:first-child');
        nextQuestionEl.addClass('active');
        progressbarValue = progressbarValue + 25;

        $(this).attr('data-active-variant', targetVariantNo);
        $(this).attr('data-active-question', nextQuestionEl.attr('data-question'));
        $('.progrss-value').val(progressbarValue);
        return true;
    }

    var currentQuestionEl = $(".question_variant[data-variant='" + activeVariantNo + "']").find('[data-question="' + activeQuestionNo + '"]');
    if (currentQuestionEl.find('input[type="text"], textarea').length) {
        // Check if input is required and not empty
        var inputField = currentQuestionEl.find('input[type="text"], textarea');
        if (inputField.prop('required') && inputField.val().trim() === '') {
            alert("Please fill in the required field.");
            return false;
        }
    }
    progressbarValue = progressbarValue + 25;
    $('.progrss-value').val(progressbarValue);
    $("#survey-next-button").html("Submit");

    var nextQuestionEl = currentQuestionEl.next();
    if (nextQuestionEl.length) {
        currentQuestionEl.removeClass('active');
        nextQuestionEl.addClass('active');

        $(this).attr('data-active-question', nextQuestionEl.attr('data-question'));
        return false;
    }
    var formData = $('#servey_form').serialize();
    $.ajax({
        type: "POST",
        url: SITE_BASE_URL + "userServey",
        data: formData,
        success: function (result) {
            alert('Thank you for your answers. We are personalizing your experience…');
            $('#serveyModal').modal('hide'); // Close the modal
            location.reload();
        },
        error: function (error) {
            console.log('error', error);
        }
    });
});

$("#survey-prev-button").click(function () {
    progressbarValue = progressbarValue - 25;
    $('.progrss-value').val(progressbarValue);
    var submitButton = $("#survey-next-button");
    var activeVariantNo = parseInt(submitButton.attr('data-active-variant'));
    var activeQuestionNo = parseInt(submitButton.attr('data-active-question'));

    var currentVariantEl = $(".question_variant[data-variant='" + activeVariantNo + "']");
    $("#survey-next-button").html("Next");

    var currentQuestionEl = currentVariantEl.find('[data-question]').attr('data-question');
    var targetQuestionChecked = $("[name='question[" + activeQuestionNo + "]']").prop("checked", false);
    var otherTextInput = currentVariantEl.find('[data-question="' + activeQuestionNo + '"] input.other_text');
    if (otherTextInput.length) {
        otherTextInput.val('');
    }
    var otherTextArea = document.querySelector('input[name="other_text[' + activeQuestionNo + ']"]');
    otherTextArea.style.display = 'none';

    if (activeQuestionNo == currentQuestionEl) {
        var targetVariant = $(".question_variant[data-variant='0']");
        targetVariant.addClass('active');
        $('.prev').addClass('hidden');
        currentVariantEl.removeClass('active');

        submitButton.attr('data-active-variant', 0);
        submitButton.attr('data-active-question', 1);
        return true;
    }
    var currentQuestion = $(".question-outer[data-question='" + activeQuestionNo + "']");
    var targetVariant = $(".question-outer[data-question='" + activeQuestionNo + "']").prev();

    currentQuestion.removeClass('active');
    targetVariant.addClass('active');

    submitButton.attr('data-active-variant', activeVariantNo);
    submitButton.attr('data-active-question', targetVariant.attr('data-question'));
});

function showOtherTextArea(radio, questionId) {
    var otherTextArea = document.querySelector('input[name="other_text[' + questionId + ']"]');
    if (radio.checked && radio.value === 'other') {
        otherTextArea.style.display = 'block';
        otherTextArea.setAttribute('required', 'required');
    } else {
        otherTextArea.style.display = 'none';
        otherTextArea.removeAttribute('required');
    }
}
async function ultraEnhancer(el) {
    runpodType = '1';
    $.ajax({
        url: 'get_next_runpod',
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
    if (user == null) {
        showLoginModal();
        return;
    }

    var precisionUserValue = document.getElementById('precisionUser').value;
    var sec = $(el).data('sec');
    var image_url = $(el).data('img');
    var route = $("#routeToImageData").data('route');
    $('.ultra-enhancer').addClass('disable-btn');
    $('.full_hd_quality').addClass('disable-btn');
    $('._btn_gndeisgn').addClass('disable-btn');
    $('.precision_btn').addClass('disable-btn');
    projectButton.disabled = true;
    deleteButton.disabled = true;

    var data = document.getElementById(`all_data${sec}`);
    const newFreeformSpacer = document.createElement('div');
    newFreeformSpacer.id = "progressindicatordiv"
    newFreeformSpacer.innerHTML = `<div class="container22" id='progid'>
			<label for="onehundred" class="label" id=hundredid${sec}></label>
			<div class="custom_loader">
				<h5 class="custom_loader_text">The AI is doing its magic, please wait 10-40 seconds...</h5>
				<svg role="img" aria-label="Mouth and eyes come from 9:00 and rotate clockwise into position, right eye blinks, then all 					parts rotate and merge into 3:00" class="smiley" viewBox="0 0 128 128" width="128px" height="128px">
				<defs>
					<clipPath id="smiley-eyes">
						<circle class="smiley__eye1" cx="64" cy="64" r="8" transform="rotate(-40,64,64) translate(0,-56)" />
						<circle class="smiley__eye2" cx="64" cy="64" r="8" transform="rotate(40,64,64) translate(0,-56)" />
					</clipPath>
					<linearGradient id="smiley-grad" x1="0" y1="0" x2="0" y2="1">
						<stop offset="0%" stop-color="#000" />
						<stop offset="100%" stop-color="#fff" />
					</linearGradient>
					<mask id="smiley-mask">
						<rect x="0" y="0" width="128" height="128" fill="url(#smiley-grad)" />
					</mask>
				</defs>
				<g stroke-linecap="round" stroke-width="12" stroke-dasharray="175.93 351.86">
					<g>
						<rect fill="hsl(193,90%,50%)" width="128" height="64" clip-path="url(#smiley-eyes)" />
						<g fill="none" stroke="hsl(193,90%,50%)">
							<circle class="smiley__mouth1" cx="64" cy="64" r="56" transform="rotate(180,64,64)" />
							<circle class="smiley__mouth2" cx="64" cy="64" r="56" transform="rotate(0,64,64)" />
						</g>
					</g>
					<g mask="url(#smiley-mask)">
						<rect fill="hsl(223,90%,50%)" width="128" height="64" clip-path="url(#smiley-eyes)" />
						<g fill="none" stroke="hsl(223,90%,50%)">
							<circle class="smiley__mouth1" cx="64" cy="64" r="56" transform="rotate(180,64,64)" />
							<circle class="smiley__mouth2" cx="64" cy="64" r="56" transform="rotate(0,64,64)" />
						</g>
					</g>
				</g>
			</svg>
			</div>
		</div>`;
    data.insertBefore(newFreeformSpacer, data.firstChild);
    document.getElementById(`jumphere${sec}`).scrollIntoView();

    var divElement = document.getElementById(`all_data${sec}`);
    divElement.firstElementChild.scrollIntoView();

    var is_staging = (APP_LOCAL == 'production') ? 'false' : 'true';

    // Disable AI category Pill
    _updateAiCatePillsStatus('disable');

    document.getElementById(`hundredid${sec}`).click();
    $.ajax({
        url: route,
        method: "POST",
        data: {
            "image": image_url
        },
        success: async function (resp) {
            var formData = new FormData();
            formData.append("data", resp.data.image);
            var customInstruction = 0;
            var roomType = resp.data.room_type;
            var strengthType = 'very_low';
            var modeType = 'Beautiful Redesign';
            var styleType = 'No Style';
            var noOfDesign = '1';

            formData.append("privateId", resp.data.privateId);
            formData.append("roomtype", roomType);
            formData.append("modeType", modeType);
            formData.append("is_staging", is_staging);
            formData.append("is_custom_instruction", customInstruction);
            formData.append("strengthType", strengthType);
            formData.append("designtype", sec);
            formData.append("no_of_Design", noOfDesign);
            formData.append("prompt", styleType);
            formData.append("runpod_name", runpodName);
            formData.append("public", 0);
            // aiAPI = `${GPU_SERVER_HOST_INIT}/enhace?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&privateId=${resp.data.privateId}&is_staging=${is_staging}&roomtype=${roomType}&modeType=${modeType}&prompt=${styleType}&designtype=${sec}&is_custom_instruction=${customInstruction}&strengthType=${strengthType}&no_of_Design=${noOfDesign}&id=${user.uid}`;
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
                    $('.ultra-enhancer').removeClass('disable-btn');
                    $('.full_hd_quality').removeClass('disable-btn');
                    $('._btn_gndeisgn').removeClass('disable-btn');
                    $('.precision_btn').removeClass('disable-btn');
                    projectButton.disabled = false;
                    // deleteButton.disabled = false;

                    genratedImage = result['Sucess']['generated_image'];
                    orignalImage = result['Sucess']['original_image'];
                    genratedImage.forEach(function (item) {
                        var data = document.getElementById(`all_data${sec}`);
                        var newFreeformSpacer = document.createElement('div');
                        data.insertBefore(newFreeformSpacer, data.firstChild);

                        var design = {
                            original_url: orignalImage,
                            generated_url: item,
                            style: resp.data.style,
                            room_type: resp.data.room_type,
                            mode: resp.data.mode,
                            show_data: true,
                            section: sec,
                            private: resp.data.privateId,
                            precisionUserValue: precisionUserValue,
                            hd_image: 0,
                        }
                        var code = createDesignItem(design);

                        var data = document.getElementById(`all_data${sec}`);
                        document.getElementById(`progid`).style.display = 'none';

                        var newFreeformSpacer = document.createElement('div');
                        newFreeformSpacer.innerHTML = code;
                        data.insertBefore(newFreeformSpacer, data.firstChild);
                    });
                })
                .catch(error => {
                    $('.ultra-enhancer').removeClass('disable-btn');
                    $('.full_hd_quality').removeClass('disable-btn');
                    $('._btn_gndeisgn').removeClass('disable-btn');
                    $('.precision_btn').removeClass('disable-btn');
                    projectButton.disabled = false;
                    // deleteButton.disabled = false;
                    console.error('Error:', error);
                });

            var progressindicatordiv = document.getElementById(`progressindicatordiv`);
            progressindicatordiv.remove();

            $(el).attr('disabled', false);

            // Enable AI category Pill
            _updateAiCatePillsStatus('enable');
        },
        error: function (resp) {
            data = resp.responseJSON;
        }
    })
}
$(document).on('click', '.generate_hd_img', async function () {
    page = 1;
    getRedesignGeneratedDesigns();
    if (user == null) {
        showLoginModal();
        return;
    }

    var precisionUserValue = document.getElementById('precisionUser').value;
    var sec = $(this).data('sec');
    $('.gs-continue-btn').addClass('disable-btn');
    $('.on-gen-disable').addClass('disable-btn');

    // document.getElementById(`hundredid${sec}`).click();
    var image_url = $(this).data('img');
    var inputImage = $(this).data('input-img');
    // $('.ultra-enhancer').addClass('disable-btn');
    // $('.full_hd_quality').addClass('disable-btn');
    // $('._btn_gndeisgn').addClass('disable-btn');
    // $('.precision_btn').addClass('disable-btn');
    projectButton.disabled = true;
    // deleteButton.disabled = true;

    generationDivLoader(1,image_url);
    $('.ai-upload-latest-designs')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    document.getElementById(`jumphere0`).scrollIntoView();

    var divElement = document.getElementById(`all_data0`);
    divElement.firstElementChild.scrollIntoView();

    // Disable AI category Pill
    _updateAiCatePillsStatus('disable');

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
            if (resp.status == false) {
                $('.gs-continue-btn').removeClass('disable-btn');
                $('.on-gen-disable').removeClass('disable-btn');
                // $('.ultra-enhancer').removeClass('disable-btn');
                // $('.full_hd_quality').removeClass('disable-btn');
                // $('._btn_gndeisgn').removeClass('disable-btn');
                // $('.precision_btn').removeClass('disable-btn');
                document.getElementById(`progid`).style.display = 'none';
            } else {
                var formData = new FormData();
                formData.append("privateId", resp.data.privateId);
                formData.append("roomtype", resp.data.room_type);
                formData.append("design_style", resp.data.style);
                formData.append("modeType", resp.data.mode);
                formData.append("is_staging", is_staging);
                formData.append("designtype", sec);
                formData.append("data", resp.data.image);
                formData.append("runpod_name", runpodName);
                formData.append("hd_image", true);
                // aiAPI = `${GPU_SERVER_HOST}/fullhd?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&id=${user.uid}&privateId=${resp.data.privateId}&is_staging=${is_staging}&roomtype=${resp.data.room_type}&design_style=${resp.data.style}&modeType=${resp.data.mode}&roomtype=${resp.data.room_type}`;
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
                        $('.gs-continue-btn').removeClass('disable-btn');
                        $('.on-gen-disable').removeClass('disable-btn');
                        projectButton.disabled = false;
                        // deleteButton.disabled = false;
                        var generated_image = result['Sucess']['generated_image'][0];
                        var original_image = result['Sucess']['original_image'];
                        let storedIds = result['storedIds'];


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
                            precisionUserValue: precisionUserValue,
                            hd_image: 1,
                        }

                        // var code = createDesignItem(design);
                        var code = generatedRedesignItem(design);

                        // Add the generated design image to the array

                        let data = document.getElementById(`all_data0`);
                        removeLoaderDivs(1);
                        //document.getElementById(`progid`).style.display = 'none';

                        data.insertBefore(code, data.firstChild);

                        // Enable AI category Pill
                        _updateAiCatePillsStatus('enable');
                    })
                    .catch(error => {
                        removeLoaderDivs(1);
                        $('.gs-continue-btn').removeClass('disable-btn');
                        $('.on-gen-disable').removeClass('disable-btn');
                        // $('.ultra-enhancer').removeClass('disable-btn');
                        // $('.full_hd_quality').removeClass('disable-btn');
                        // $('._btn_gndeisgn').removeClass('disable-btn');
                        // $('.precision_btn').removeClass('disable-btn');
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

function changeMode(sec) {
    var modeValue = document.getElementById(`modeType${sec}`);
    var selectedOption = modeValue.options[modeValue.selectedIndex].value;
    // var strengthValue = document.getElementById(`strength${sec}`);
    var rangeInput = document.getElementById(`rangeInput${sec}`);
    $.each($(".dash-link"), function () {
        if ($(this).hasClass('active')) {
            // $("#sidebarmodule").val($(this).attr('tag'));
            $(this).attr('tag', selectedOption);
        }
    });
    if (selectedOption === "Creative Redesign") {
        // strengthValue.value = "mid"; // Change the value of the first dropdown
        rangeInput.value = 75;
    } else if (selectedOption === "Fill The Room" || selectedOption === "Fill The Exterior" || selectedOption === "Fill The Garden") {
        // strengthValue.value = "mid";
        rangeInput.value = 75;
        $("#suggestionPrecisionModal").modal('show');
    } else if (selectedOption === "Beautiful Redesign") {
        // strengthValue.value = "mid";
        rangeInput.value = 75;
    }
}

function showUpdateModal() {
    $("#modalUpgradePlan").modal('show');
}

// Start Feedback Functionality
$(document).on('click', '.showFeedbackModal', function () {
    // check sidebar module
    let design_type = $(this).attr('design_type');
    if (typeof design_type !== 'undefined' && design_type !== false) {
        $("#sidebarmodule").val(design_type);
    } else {
        $.each($(".dash-link"), function () {
            if ($(this).hasClass('active')) {
                $("#sidebarmodule").val($(this).attr('tag'));
            }
        });
    }

    // add tab module from interior, exterior and Gardens
    $.each($(".nwai-tab"), function () {
        if ($(this).hasClass('active')) {
            $("#module_category").val($(this).find(".nwtb-title").text());
        }
    });
    document.getElementById('rating3-none').checked = true;
    $("#feedbackForm").modal('show');
    var imgValue = $(this).data('img');
    $('#feedback_image').val(imgValue); //Set value of generated image in modal for retriving more data from the DB
    $('#gallery_id').val($(this).data('id')); //Set value of generated image in modal for retriving more data from the DB

});

$(document).on('click', '#feedback_submit_button', function () {
    let generated_image = $('#feedback_image').val();
    let gallery_id = $('#gallery_id').val();

    let feedback_description = '';
    let feedback_ratings = 1;

    feedback_description = $('#feedback_description').val();
    feedback_ratings = $('input:radio[name=rating3]:checked').val();
    if (document.getElementById('sidebarmodule')) {
        sidebarmodule = $('#sidebarmodule').val();
    } else {
        sidebarmodule = null;
    }
    if (document.getElementById('module_category')) {
        module_category = $('#module_category').val();
    } else {
        module_category = null;
    }

    if (feedback_description == '') {
        alert("Please add detailed feedback description!");
        return false;
    }
    if (feedback_ratings == 0) {
        alert("Please provide feedback ratings!");
        return false;
    }

    let payloadData = {
        generated_image: generated_image,
        gallery_id: gallery_id,
        feedback_description: feedback_description,
        feedback_ratings: feedback_ratings,
        module: sidebarmodule,
        module_category: module_category
    };

    $.ajax({
        url: "/feedback/store",
        type: "POST",
        data: payloadData,
        beforeSend: function (xhr) {
            var csrfToken = $('meta[name=csrf-token]').attr('content');
            xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
            $("#feedback_submit_button").text("Sending...");
        },
        success: function (response) {
            if (response.success) {
                $('#feedback_description').val('');
                document.getElementById('rating3-none').checked = true;

                $("#feedbackForm").modal('hide');
                Swal.fire({
                    title: 'Received!',
                    text: response.message,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Generate Again',
                    cancelButtonText: 'Close Message'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('rating3-none').checked = true;
                        $("#feedbackForm").modal('show');
                        $('#feedback_image').val(generated_image);
                    }
                });
                $("#feedback_submit_button").text("Submit Feedback");
                // window.location.reload();
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error',
                    showCancelButton: true,
                    cancelButtonText: 'Ok'
                })
            }
        },
        error: function (resp) {
            data = false;
            $('#feedback_description').val('');
            document.getElementById('rating3-none').checked = true;
            $("#feedback_submit_button").text("Submit Feedback");
        }
    });

});
// End Feedback Functionality


function get_access_token() {
    var url = SITE_BASE_URL + 'getTokenDetails'
    $.ajax({
        url: url,
        type: "POST",
        async: false,
        beforeSend: function () {
            // setting a timeout
            $(".access_token_button").html("<i class='fa fa-spinner fa-spin p-0'></i> Generating...");
        },
        success: function (resp) {
            if (resp.success == true) {
                let user_name = resp.data.name;
                let user_email = resp.data.email;
                aiAPI = `/get_token`; //`${API_GPU_SERVER_HOST}/get_token`;
                var payload = {
                    "_token": $('meta[name=csrf-token]').attr('content'),
                    "name": user_name,
                    "email": user_email,
                };
                fetch(aiAPI, {
                    method: 'POST',
                    headers: {
                        accept: 'multipart/form-data',
                        'Access-Control-Allow-Origin': '*',
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content'),
                        'Content-Type': 'application/json', // Set the content type to JSON
                    },
                    crossDomain: true,
                    body: JSON.stringify(payload),
                })
                    .then(response => {
                        if (response.status == 501) {
                            modalStore.style.display = 'block';
                        }
                        return response.json();
                    })
                    .then(result => {
                        let access_Token = result.access_token;
                        saveTokenToDatabase(user_email, access_Token);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                alert(resp.error);
            }
        },
        error: function (resp) { }
    })
}

function saveTokenToDatabase(email, token) {
    const saveTokenAPI = '/api/save_token'; // Replace with the actual Laravel API endpoint
    const payload = {
        email: email,
        access_token: token,
    };
    $.ajax({
        url: saveTokenAPI,
        type: "POST",
        data: payload,
        async: false,
        success: function (resp) {
            alert("Token Generated Succesfully");
            window.location.reload();
        },
        error: function (resp) {
            data = false;
        }
    })
}

$(document).on('click', '.edit_with_precision', function () {
    if (user == null) {
        showLoginModal();
        return;
    }
    var precisionUserValue = document.getElementById('precisionUser').value;
    if (!precisionUserValue) {
        $("#modalUpgradePlan").modal('show');
        return;
    }
    var img = $(this).data('img');
    var url = $(this).data('url');
    var routeURL = document.getElementById('editAsPrecision').getAttribute('data-route');

    // $('.ultra-enhancer').addClass('disable-btn');
    // $('.full_hd_quality').addClass('disable-btn');
    // $('._btn_gndeisgn').addClass('disable-btn');
    // $('.precision_btn').addClass('disable-btn');

    $.ajax({
        type: 'POST',
        url: routeURL,
        data: { img: img },
        success: function (response) {
            if (response.success) {
                // Redirect to the 'precision+' route
                if(url == 1){
                    window.location.href = '/user/precision?imageCacheId=' + response.image_cache_id;
                }else if(url == 2){
                    window.location.href = '/user/fill-spaces?imageCacheId=' + response.image_cache_id;
                }else if(url == 3){
                    window.location.href = '/user/decorStaging?imageCacheId=' + response.image_cache_id;
                }else if(url == 4){
                    window.location.href = '/user/ai-furniture-removal?imageCacheId=' + response.image_cache_id;
                }else if(url == 5){
                    window.location.href = '/user/change-colors-texture?imageCacheId=' + response.image_cache_id;
                }else if(url == 6){
                    window.location.href = '/sky-color?imageCacheId=' + response.image_cache_id;
                }else if(url == 7){
                    window.location.href = '/material-swap?imageCacheId=' + response.image_cache_id;
                }else if(url == 8){
                    window.location.href = '/paint-visualizer?imageCacheId=' + response.image_cache_id;
                }else if(url == 9){
                    window.location.href = '/room-blend?imageCacheId=' + response.image_cache_id;
                }else if(url == 10){
                    window.location.href = '/design-transfer?imageCacheId=' + response.image_cache_id;
                }else if(url == 99){
                    window.location.href = '/convenient-redesign?imageCacheId=' + response.image_cache_id;
                }else if(url == 11){
                    window.location.href = '/floor-editor?imageCacheId=' + response.image_cache_id;
                }else{
                    window.location.href = '/redesign?imageCacheId=' + response.image_cache_id;
                }
            }
        },
        error: function (error) {
            console.error('AJAX error:', error);
        }
    });
});
$("#closeserveyModal").click(function () {
    $('#serveyModal').hide(); // Close the modal
});

$("#closeSuggestionPrecisionModal").click(function () {
    $("#suggestionPrecisionModal").hide();
});

async function addRemovefavorite(id) {
    const imageElement = document.getElementsByClassName(`favoriteImage${id}`);
    // const hideImageElemnt = document.getElementById(`favoriteImage${src}`);
    $.ajax({
        url: SITE_BASE_URL + 'updateFavorite',
        type: "POST",
        data: {
            image_id: id
        },
        success: function (response) {
            if (response != null) {
                if (response.is_favorite) {
                    for (let i = 0; i < imageElement.length; i++) {
                        imageElement[i].src = '/web2/images/ai-upload-favourite-checked-1.svg';
                    }
                }
                else {
                    for (let i = 0; i < imageElement.length; i++) {
                        imageElement[i].src = '/web2/images/ai-upload-favourite-checked.svg';
                    }
                    // if(hideImageElemnt){
                    //     $(hideImageElemnt).hide();
                    //     multipleDownloadImg.splice(multipleDownloadImg.indexOf(src), 1);

                    //     if (multipleDownloadImg.length > 0) {
                    //         $(`.delete_button`).removeClass('hidden');
                    //         $(`.download_button`).removeClass('hidden');
                    //     } else {
                    //         $(`.delete_button`).addClass('hidden');
                    //         $(`.download_button`).addClass('hidden');
                    //     }
                    // }
                }
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}
$('document').ready(function () {
    var search_img = sessionStorage.getItem('search_img');
    if (search_img) {
        loadSearchImg(search_img);
        sessionStorage.removeItem('search_img');
    }
    if (window.innerWidth < 991) {
        initComparisons();
    }
    else {
        var inkboxes = document.querySelectorAll(".inked-painted");
        var coloredBoxes = document.querySelectorAll(".colored");
        var fillerImages = document.querySelectorAll(".inked");

        for (var i = 0; i < inkboxes.length; i++) {
            inkboxes[i].addEventListener("mousemove", trackLocation.bind(null, i), false);
            inkboxes[i].addEventListener("touchstart", trackLocation.bind(null, i), false);
            inkboxes[i].addEventListener("touchmove", trackLocation.bind(null, i), false);
        }

        function trackLocation(sectionIndex, e) {
            var rect = fillerImages[sectionIndex].getBoundingClientRect();
            var position = ((e.pageX - rect.left) / fillerImages[sectionIndex].offsetWidth) * 100;
            if (position <= 100) { coloredBoxes[sectionIndex].style.width = position + "%"; }
        }
    }

    var url = window.location.href;
    if (url.indexOf('/redesign') !== -1 || url.indexOf('/convenient-redesign') !== -1) {
        if (url.indexOf('?imageCacheId=') !== -1) {
            getImageCache(GetParameterValues('imageCacheId'), function(response, error) {
                if (response.success) {
                    // Redirect to the 'precision+' route
                    loadImageBase64FromInpainting(response.data);
                }
            });
        } else if (url.indexOf('&imageCacheId=') !== -1) {
            return true;
        }
    }
});

function initComparisons() {
    var x, i;
    x = document.getElementsByClassName("colored");
    for (i = 0; i < x.length; i++) {
        compareImages(x[i]);
    }

    function compareImages(img) {
        var slider, img, clicked = 0, w, h;
        w = img.offsetWidth;
        h = img.offsetHeight;
        img.style.width = (w / 2) + "px";
        slider = document.createElement("DIV");
        slider.setAttribute("class", "img-comp-slider");
        img.parentElement.insertBefore(slider, img);
        slider.style.top = (h / 2) - (slider.offsetHeight / 2) + "px";
        slider.style.left = (w / 2) - (slider.offsetWidth / 2) + "px";

        slider.addEventListener("mousedown", slideReady);
        window.addEventListener("mouseup", slideFinish);
        slider.addEventListener("touchstart", slideReady);
        window.addEventListener("touchend", slideFinish);

        function slideReady(e) {
            e.preventDefault();
            clicked = 1;
            window.addEventListener("mousemove", slideMove);
            window.addEventListener("touchmove", slideMove);
        }

        function slideFinish() {
            clicked = 0;
        }

        function slideMove(e) {
            var pos;
            if (clicked == 0) return false;
            pos = getCursorPos(e)
            if (pos < 0) pos = 0;
            if (pos > w) pos = w;
            slide(pos);
        }

        function getCursorPos(e) {
            var a, x = 0;
            e = (e.changedTouches) ? e.changedTouches[0] : e;
            a = img.getBoundingClientRect();
            x = e.pageX - a.left;
            x = x - window.pageXOffset;
            return x;
        }

        function slide(x) {
            img.style.width = x + "px";
            slider.style.left = img.offsetWidth - (slider.offsetWidth / 2) + "px";
        }
    }
}

$(document).ready(function () {
    // localStorage.removeItem('feedbackModalClosedCount');
    var feedbackModalClosedCount = localStorage.getItem('feedbackModalClosedCount') || 0;

    $("#closefeedbackModal").click(function () {
        feedbackModalClosedCount++;
        localStorage.setItem('feedbackModalClosedCount', feedbackModalClosedCount);
        $("#feedbackModel").hide();
        if(feedbackModalClosedCount >= 2){
            var route = $('#feedbackModelRoute').data('route');
            $.ajax({
                url: route,
                type: 'POST',
                data: {},
                success: function (response) {
                },
                error: function (xhr, status, error) {
                    console.error('Error increasing count:', error);
                }
            });
        }
    });
});

$('#submitFeedbackRating').click(function () {
    var selectedRating = $('input[name="rate"]:checked').val();
    if (selectedRating == undefined || selectedRating == '') {
        alert("Please select star to give rating!");
        return
    }
    if (selectedRating <= 3) {
        $('.feedback_heading_div').hide();
        $('.bad_review').show();
    }
    else {
        $('.feedback_heading_div').hide();
        $('.good_review').show();
        storeReviews();
    }
});

$("#submitFeedback").click(function () {
    var userFeedback = $('textarea[name="userfeedback"]').val();
    if (userFeedback == undefined || userFeedback == '') {
        alert('Please fill the feedback!');
        return
    }
    storeReviews();
    $("#feedbackModel").hide();
});

$(".trustpilot-widget").click(function () {
    $("#feedbackModel").hide();
});

function storeReviews() {
    var selectedRating = $('input[name="rate"]:checked').val();
    var userFeedback = $('textarea[name="userfeedback"]').val();
    $.ajax({
        type: "POST",
        url: SITE_BASE_URL + "userfeedback",
        data: {
            rating: selectedRating,
            feedback: userFeedback,
        },
        success: function (response) {
            $('input[name="rate"]:checked').prop('checked', false);
            $('textarea[name="userfeedback"]').val('');
        },
        error: function (error) {
            console.log('error', error);
        }
    });
}

$(".new-project-btn").click(function () {
    $("#createProjectForm")[0].reset();
    $("#createProjectForm").validate().resetForm();
    $('#modalTitle').text('Create New Project');
    var createRoute = $('#createProjectRoute').data('route');
    $('#createProjectForm input[name="_method"]').remove();
    $('#createProjectForm').attr('action', createRoute);
    $('#create-project-btn').text('Create');
    $("#createProjectModel").modal('show');
});

$("#createProjectForm").submit(function (event) {
    event.preventDefault();
    var form = $(this);
    var url = form.attr('action');

    // Clear previous errors
    $(".text-danger").remove();

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function (response) {
            if (response.success) {
                $("#project_add_new_modal").modal('hide');
                $("#project_success_modal").modal('show');

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                // Handle the validation errors
                var errors = response.errors;
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        var errorMessage = errors[key][0];
                        $("#" + key).after('<div class="text-danger">' + errorMessage + '</div>');
                    }
                }
            }
        },
        error: function (xhr, status, error) {
            // Handle the error
            console.log(error);
        }
    });
});


$(".add_to_project_btn").click(function () {
    $("#addToprojectmodal").modal('show');
})

$(".add_to_project_cancel_btn").click(function () {
    $("#addProjectForm")[0].reset();
    $("#addProjectForm").validate().resetForm();
    $("#addToprojectmodal").modal('hide');
    $('#subprojectGroup').hide();
})

$(".create_project_close_btn").click(function () {
    $("#createProjectForm")[0].reset();
    $("#createProjectForm").validate().resetForm();
    $("#createProjectModel").modal('hide');
})

function addToProject() {
    var route = $('#addImagesToProject').data('route');
    var selectProject = $('#selectProject').val();
    var selectSubProject = $('#selectSubProject').val();

    var isValid = $('#addProjectForm').valid();
    if (isValid) {
        $.ajax({
            method: "POST",
            url: route,
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                images: this.multipleDownloadImg,
                selectProject: selectProject,
                selectSubProject: selectSubProject,
            },
            success: function (response) {
                $("#success_project_modal").modal('show');
                $('#jumphere0').css('display', 'none');
                $('.ml_dw_img').prop('checked', false);
                this.multipleDownloadImg = [];
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    // Clear previous errors
                    $('.text-danger').remove();
                    $.each(errors, function (key, value) {
                        $('#' + key).after('<div class="text-danger">' + value[0] + '</div>');
                    });
                } else {
                    var error = error.responseJSON;
                    Swal.fire(
                        'Oops!',
                        error.message,
                        'warning'
                    )
                }
            }
        });
    }
}

$(".new-sub-project-btn").click(function () {
    $("#createSubProjectForm")[0].reset();
    $("#createSubProjectForm").validate().resetForm();
    $('#subModalTitle').text('Create New Sub Project');
    var createRoute = $('#createSubProjectRoute').data('route');
    $('#createSubProjectForm input[name="_method"]').remove();
    $('#createSubProjectForm').attr('action', createRoute);
    $('#create-project-btn').text('Create');
    $("#project_add_new_modal").modal('show');
});

$("#createSubProjectForm").submit(function (event) {
    event.preventDefault(); // Prevent default form submission
    var form = $(this);
    var url = form.attr('action');

    // Clear previous errors
    $(".text-danger").remove();

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // Serialize form data for submission
        success: function (response) {
            if (response.success) {
                $("#project_add_new_modal").modal('hide');
                $("#project_success_modal").modal('show');

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                // Handle validation errors
                var errors = response.errors;
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        var errorMessage = errors[key][0];
                        $("#" + key).after('<div class="text-danger">' + errorMessage + '</div>');
                    }
                }
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

function editProject(projectID) {
    // Reset the form and validation state
    $("#createProjectForm")[0].reset();
    $("#createProjectForm").validate().resetForm();

    // Clear previous errors
    $(".text-danger").remove();

    // Set modal title and button text
    $('#modalTitle').text('Edit Project');
    $('#create-project-btn').text('Update');

    // Set the form action to the update route
    var updateRoute = $('#updateProjectRoute').data('route');
    $('#createProjectForm').attr('action', updateRoute.replace('__ID__', projectID));

    // Add the hidden _method input for PUT request
    $('#createProjectForm').append('<input type="hidden" name="_method" value="PUT">');

    // Perform an AJAX request to fetch project details
    var editRoute = $('#editProjectRoute').data('route');
    $.ajax({
        url: editRoute.replace('__ID__', projectID),
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#projectID').val(data.id);
            $('#projectname').val(data.project_name);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    // Show the modal
    $('#project_add_new_modal').modal('show');
}

function deleteProject(projectID) {
    var deleteRoute = $('#deleteProjectRoute').data('route');
    $("#confirm_project_modal").modal('show');

    $(".yes-confirm-project-modal").off('click').on('click', function() {
        $.ajax({
            url: deleteRoute.replace('__ID__', projectID),
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $("#confirm_project_modal").modal('hide');

                $('li[data-encrypted-id="' + projectID + '"]').hide();

                $("#confirm_delete_modal").modal('show');

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            },
            error: function(xhr, status, error) {
                var errorResponse = xhr.responseJSON;
                Swal.fire(
                    'Oops!',
                    errorResponse.message,
                    'warning'
                );
            }
        });
    });
}

$(".create_sub_project_close_btn").click(function () {
    $("#createSubProjectForm")[0].reset();
    $("#createSubProjectForm").validate().resetForm();
    $("#createSubProjectModel").modal('hide');
})

function editSubProject(subProjectID) {
    $("#createSubProjectForm")[0].reset();
    $("#createSubProjectForm").validate().resetForm();
    var editRoute = $('#editSubProjectRoute').data('route');
    $('#subModalTitle').text('Edit Sub Project');
    var updateRoute = $('#updateSubProjectRoute').data('route');
    $('#createSubProjectForm').attr('action', updateRoute.replace('__ID__', subProjectID));
    $('#createSubProjectForm').append('<input type="hidden" name="_method" value="PUT">');
    $.ajax({
        url: editRoute.replace('__ID__', subProjectID),
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#subProjectID').val(data.id);
            $('#subprojectname').val(data.sub_project_name);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    $('#create-project-btn').text('Update');
    $('#project_add_new_modal').modal('show');
}

function deleteSubProject(subProjectID) {
    var deleteRoute = $('#deleteSubProjectRoute').data('route');
    $("#confirm_sub_project_modal").modal('show');

    $(".yes-confirm-sub-project-modal").off('click').on('click', function() {
        $.ajax({
            url: deleteRoute.replace('__ID__', subProjectID),
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $("#confirm_sub_project_modal").modal('hide');

                $('li[data-encrypted-id="' + subProjectID + '"]').hide();

                $("#confirm_delete_modal").modal('show');

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            },
            error: function(xhr, status, error) {
                var errorResponse = xhr.responseJSON;
                Swal.fire(
                    'Oops!',
                    errorResponse.message,
                    'warning'
                );
            }
        });
    });
}

function removeImagesFromFolder(projectId, subProjectId) {
    var removeImagesRoute = $('#removeImagesFromFolder').data('route');
    $("#confirm_modal").modal('show');

    // Store the project and subproject IDs in the modal's data attributes
    $("#confirm_modal").data('projectId', projectId);
    $("#confirm_modal").data('subProjectId', subProjectId);

    $(".yes-confirm-modal").off('click').on('click', function() {
        var projectId = $("#confirm_modal").data('projectId');
        var subProjectId = $("#confirm_modal").data('subProjectId');

        $.ajax({
            url: removeImagesRoute,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                images: multipleDownloadImg,
                projectId: projectId,
                subProjectId: subProjectId
            },
            success: function(response) {
                $("#confirm_delete_modal").modal('show');
                multipleDownloadImg.forEach(function(id) {
                    $(`.ai-upload-latest-single[data-image-id="${id}"]`).remove();
                });
                multipleDownloadImg = [];
                $(`.delete_favourite_buttons`).addClass('hidden');
            },
            error: function(xhr, status, error) {
                var errorResponse = xhr.responseJSON;
                Swal.fire(
                    'Oops!',
                    errorResponse.message,
                    'warning'
                );
            }
        });

        // Hide the initial confirmation modal
        $("#confirm_modal").modal('hide');
    });
}

$('#openCreateProjectModal').click(function (e) {
    e.preventDefault();
    sessionStorage.setItem('showCreateProjectModal', 'true');
    var targetUrl = $(this).attr('href');
    window.location.href = targetUrl;
});

$(document).ready(function () {
    var showModal = sessionStorage.getItem('showCreateProjectModal');
    if (showModal === 'true') {
        setTimeout(function () {
            $("#createProjectForm")[0].reset();
            $("#createProjectForm").validate().resetForm();
            $('#modalTitle').text('Create New Project');
            var createRoute = $('#createProjectRoute').data('route');
            $('#createProjectForm input[name="_method"]').remove();
            $('#createProjectForm').attr('action', createRoute);
            $('#create-project-btn').text('Create');
            $("#createProjectModel").modal('show');
        }, 500);
        sessionStorage.setItem('showCreateProjectModal', 'false');
    }
});

var resultArray = '';

async function _generateProducts(sec, el) {
    // $("#keyBars").hide();
    // $(".product-results").hide();
    resultArray = '';
    var $container = $("#forminterior" + sec);
    let image_type = $container.find("[name='image_type'").val();
    let image = $container.find("[name='image'").val();
    if (image == '') {
        alert("Make sure you add an Input Image!");
        $(el).attr('disabled', false);
        return;
    }
    $('#gen_spinner').removeClass('dis_spinner');
    $("#degn_btn_id").addClass('fur_find_disb');
    var is_staging = (APP_LOCAL == 'production') ? 'false' : 'true';

    var formData = new FormData();
    formData.append("data", image);

    formData.append("image_type", image_type);
    formData.append("is_staging", is_staging);
    var aiAPI = null;
    // aiAPI = `${GPU_SERVER_HOST}/image_seperate?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&id=${user.uid}&image_type=${image_type}&is_staging=${is_staging}`;
    aiAPI = "/runpod/image_seperate";
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
            if (result['error']) {
                $('#gen_spinner').addClass('dis_spinner');
                $("#degn_btn_id").removeClass('fur_find_disb');
                $("#keyBars").hide();
                $(".product-results").hide();
                $(".product-results").removeClass('d-flex');
                alert(result['error']);
                return;
            }
            genratedImage = result['Sucess']['generated_image'];
            var formData = new FormData();
            for (var key in genratedImage) {
                if (genratedImage.hasOwnProperty(key)) {
                    var images = genratedImage[key];
                    for (var i = 0; i < images.length; i++) {
                        formData.append(key, images[i]);
                    }
                }
            }
            formData.append("countryCode", $("#countryCode").find(":selected").val());
            $.ajax({
                type: 'POST',
                url: '/vision/search',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('.segment-masking-container').hide();
                    $('.top-menu-bar-second').hide();
                    $('.searched_product_result').show();
                    $('.top-menu-bar-third').show();
                    $('.image-mask-container').hide();
                    $("#keyBars").show();
                    $(".product-results").show();
                    $('#gen_spinner').addClass('dis_spinner');
                    $("#degn_btn_id").removeClass('fur_find_disb');
                    if (response['success'] === false) {
                        // Display an error message
                        alert('No Furniture Found. Please try again.');
                        return; // Stop further execution
                    }
                    resultArray = response.resultArray;
                    var barKeys = [];
                    var keyMap = {}; // Map to store the original keys for each formatted key

                    for (var key in resultArray) {
                        if (resultArray.hasOwnProperty(key)) {
                            var convertedKey = convertKey(key);
                            // Store the original key in the map
                            keyMap[convertedKey] = key;
                            barKeys.push(convertedKey);
                        }
                    }
                    // Create a container div for key bars with common styling
                    // var keyBarsHtml = '<div class="key-bar-tabs active" data-key="all">All</div>';
                    var keyBarsHtml = '<li class="key-bar-tabs active" data-key="all"><a data-toggle="tab" href="#googleResults"> All</a></li>';

                    barKeys.forEach(function (formattedKey) {
                        var originalKey = keyMap[formattedKey]; // Retrieve the original key from the map

                        // Add styling to each key bar
                        keyBarsHtml += '<li class="key-bar-tabs" data-key="' + originalKey + '"><a data-toggle="tab" href="#googleResults">' + formattedKey + '</a></li>';
                        // keyBarsHtml += '<div class="key-bar-tabs" data-key="' + originalKey + '">' + formattedKey + '</div>';
                    });

                    // Append filter bar html
                    // keyBarsHtml += '<div class="form-check form-switch pull-right">';
                    // keyBarsHtml += '<input class="form-check-input" type="checkbox" id="enable_location" name="enable_location" value="'+response.currencyCymbol+'">';
                    // keyBarsHtml += '<label class="form-check-label text-white" for="enable_location">Only your location</label>';
                    // keyBarsHtml += '</div>';
                    // Append the key bars container to the #keyBars container
                    $('#keyBars').html(keyBarsHtml);

                    $('#enable_location').change(function () {
                        if ($(this).is(':checked')) {
                            let currency = $(this).val();
                            // hide other currency card if checkbox is checked
                            $(".product-card").hide();
                            $("." + currency).show();
                        } else {
                            // show all cards if checkbox is unchecked
                            $(".product-card").show();
                        }
                    });
                    // Initial display with "All" as active
                    displayResults('all', resultArray);
                },
                error: function (error) {
                    // Handle the error response
                    console.error(error);
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
// Event listener for key bars
$(document).on('click', '.key-bar-tabs', function () {
    // Remove active class from all key bars
    $('.key-bar-tabs').removeClass('active');

    // Add active class to the clicked key bar
    $(this).addClass('active');
    // Get the selected key
    var selectedKey = $(this).data('key');
    // Display results based on the selected key
    displayResults(selectedKey, resultArray);
});

function displayResults(selectedKey, resultArray) {
    var cardsHtml = "";
    // Filter results based on the selected key
    var filteredResults = [];
    if (selectedKey == 'all') {
        Object.values(resultArray).forEach(function (keyItems) {
            // Concatenate the items of the current key to filteredResults
            filteredResults = filteredResults.concat(keyItems);
        });
    } else {
        filteredResults = resultArray[selectedKey];
    }
    // Generate HTML for the filtered results
    cardsHtml += '<div class="gs-simlar-products-list-row">';

    filteredResults.forEach(function (item, index) {
        // Open a new row for every 6 cards
        // if (index % 6 === 0) {
        //     cardsHtml += '<div class="row">';
        // }

        cardsHtml += '<div class="gs-simlar-products-single">'; // Use col-md-2 for 6 cards in a row
        cardsHtml += '<div class="gs-dashboard-listing">';
        cardsHtml += '<div class="gs-dashboard-list-image">';
        cardsHtml += '<img src="' + item.thumbnail + '" alt="' + item.title + '">'; // Adjust the height and use object-fit
        cardsHtml += '<div class="gs-simlar-products-company">';
        cardsHtml += '<img src="' + item.source_icon + '" alt="' + item.source + '">';
        cardsHtml += '<span>' + item.source + '</span>';
        cardsHtml += '</div>';
        cardsHtml += '</div>';
        cardsHtml += '<div class="gs-dashboard-list-content">';
        // Check if the title length is greater than 40
        if (item.title.length > 40) {
            // If it is, take the first 39 characters and add three dots
            var truncatedTitle = item.title.substring(0, 39) + '...';
            cardsHtml += '<p>' + truncatedTitle + '</p>';
        } else {
            // If not, use the original title
            cardsHtml += '<p>' + item.title + '</p>';
        }
        if (item.price) {
            cardsHtml += '<h2>' + item.price.value + '</h2>';
        } else {
            cardsHtml += '<h2>No price available</h2>';
        }
        if (item.link) {
            cardsHtml += '<a href="' + item.link + '" target="_blank">Buy Now</a>';
        }
        cardsHtml += '</div>';
        cardsHtml += '</div>';
        cardsHtml += '</div>';
        // Close the row for every 6 cards
        // if ((index + 1) % 6 === 0 || (index + 1) === filteredResults.length) {
        //     cardsHtml += '</div>';
        // }
    });
    cardsHtml += '</div>';

    // Add closing row tag if the last row is not complete (less than 5 cards)
    // if (filteredResults.length % 5 !== 0) {
    //     cardsHtml += '</div>';
    // }

    // Update the HTML in the results container
    $('#googleResults').html(cardsHtml);
}

function convertKey(key) {
    // Split the key using underscores
    var parts = key.split('_');

    // Capitalize the first letter of each part
    var convertedParts = parts.map(function (part) {
        return part.charAt(0).toUpperCase() + part.slice(1);
    });

    // Join the parts back together with a space
    return convertedParts.join(' ');
}

$(document).on('click', '.search_with_google', function () {
    if (user == null) {
        showLoginModal();
        return;
    }
    var img = $(this).data('img');
    var routeURL = document.getElementById('editAsPrecision').getAttribute('data-route');
    $.ajax({
        type: 'POST',
        url: routeURL,
        data: { img: img },
        success: function (response) {
            if (response && response.b64image) {
                var b64image = 'data:image/png;base64,' + response.b64image;
                sessionStorage.setItem('search_img', b64image);
                window.location.href = '/furniture-finding';
            }
        },
        error: function (error) {
            console.error('AJAX error:', error);
        }
    });
});

function loadSearchImg(search_img) {
    var section = 0;
    var sectionId = section;
    let gallery = document.getElementById(`gallery${sectionId}`);
    gallery.style.display = 'block';

    let uploadText = document.getElementById(`uploadText${sectionId}`);
    uploadText.style.display = 'none';

    document.getElementsByClassName(`drop-cont${sectionId}`)[0].style.visibility = 'hidden';
    let img = document.createElement('img')

    if (search_img) {
        img.src = search_img
    }
    document.getElementById(`gallery${section}`).removeChild(document.getElementById(`gallery${section}`)
        .firstElementChild);
    document.getElementById(`gallery${section}`).appendChild(img);
    $("#forminterior" + section).find("[name='image_type']").val('blob');
    $("#forminterior" + section).find("[name='image']").val(search_img);
    _generateProducts(0, this);
}

let copyText = document.querySelector(".upgrade_yearly_text");
if (copyText) {
    copyText.querySelector("a").addEventListener("click", function () {
        let input = copyText.querySelector("input.text");
        input.removeAttribute("disabled");
        input.select();
        document.execCommand("copy");
        input.setAttribute("disabled", true);
        copyText.classList.add("active");
        window.getSelection().removeAllRanges();
        setTimeout(function () {
            copyText.classList.remove("active");
        }, 2500);
    });
}

$("#closeProYearlyModal").click(function () {
    $("#upgradeToProYearly").hide();
    var route = $('#proYearlyModelRoute').data('route');
    $.ajax({
        url: route,
        type: 'POST',
        data: {},
        success: function (response) {
        },
        error: function (xhr, status, error) {
            console.error('Error increasing count:', error);
        }
    });
});

$(".showfreetraimodel").click(function () {
    $("#showFreeTrailBuyModel").modal('show');
});

$(".free_trail_model_close_btn").click(function () {
    $("#showFreeTrailBuyModel").modal('hide');
});


function setImageCache(base64Image, callback) {
    $.ajax({
        type: 'POST',
        url: "/image/cache",
        data: { image: base64Image, 'cache_type': 'precision_plus' },
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr('content')
        },
        success: function (response) {
            callback(response);
        },
        error: function (error) {
            callback(error);
        }
    });
}
var page = 1;
function generatedRedesignItem(item) {
    var temp = document.getElementById("redesignCard");
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
    var modeTypeSpan = clone.querySelector('.render-overlay-data-box .render-overlay-data:nth-child(3)');
    // var precision_enhance = clone.querySelector('.precision-ultra-enhancer');
    var hdImageDiv = clone.querySelector('.hd_image_div');

    // var dynamicClass = "favoriteImage" + item.id;
    // var favImg = clone.querySelector('.favcheckimg');
    // favImg.classList.add(dynamicClass);

    // favImg.setAttribute('onclick', `addRemovefavorite('${item.id}')`);
    // checkbox.setAttribute('onclick', `getMultipleImages('${item.id}')`);
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
    if (item.style && item.style !== 'N/A') {
        styleSpan.textContent = "Style: " + item.style;
    } else {
        styleSpan.style.background = 'transparent';
        styleSpan.style.display = 'none';
    }
    if (item.room_type && item.room_type !== 'N/A') {
        if (item.section == 1) {
            roomTypeSpan.textContent = "House Angle: " + item.room_type;
        } else if (item.section == 2) {
            roomTypeSpan.textContent = "Garden Type: " + item.room_type;
        } else {
            roomTypeSpan.textContent = "Room Type: " + item.room_type;
        }
    } else {
        roomTypeSpan.style.background = 'transparent';
        roomTypeSpan.style.display = 'none';
    }
    if (item.mode !== undefined && item.mode !== '' && item.mode != 'N/A') {
        modeTypeSpan.textContent = "Mode Type: " + item.mode;
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

$(document).on('click', '.new-page-link', function () {
    page = $(this).attr('data-url').split('=').pop();
    var pageTypes = '';
    if(dataPage == 'favourite'){
        pageTypes = 'favorites';
    }else{
        pageTypes = '';
    }
    getRedesignGeneratedDesigns(pageTypes);
    // page = 1;
});

let get_designs = {
    url: SITE_BASE_URL + 'get-designs',
}

function getRedesignGeneratedDesigns(type) {
    var response = null;
    // let paintingDesignUrl = $('#getInPaintingDesigns').data('url');
    $.ajax({
        url: get_designs.url,
        data: {
            page: page,
            pageType: type,
            designType: get_designs.design_type,
            type: get_designs.type,
            modeType: get_designs.mode_type
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

$(".add_all_images_as_favourite").click(function () {
    var route = $('#addAllImagesAsFavourite').data('route');
    $.ajax({
        url: route,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            ids: multipleDownloadImg
        },
        success: function (response) {
            response.forEach(item => {
                const imageElements = document.getElementsByClassName(`favoriteImage${item.id}`);
                for (let i = 0; i < imageElements.length; i++) {
                    if (item.is_favorite) {
                        imageElements[i].src = '/web2/images/ai-upload-favourite-checked-1.svg';
                    } else {
                        imageElements[i].src = '/web2/images/ai-upload-favourite-checked.svg';
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            var error = error.responseJSON;
            Swal.fire(
                'Oops!',
                error.message,
                'warning'
            )
        }
    });
});

// $(".gs-modal-best-btns a").click(function () {
//     setTimeout(function () {
//         $('.gs-modal-uploading_instruction_slider')[0].slick.refresh();
//     }, 400);
//     setTimeout(function () {
//         $('.top-menu-bar-first').css('display', 'none');
//         $('.upload-image-container').css('display', 'none');
//         $('.searched_product_result').css('display', 'none');
//         $('.top-menu-bar-second').css('display', 'flex');
//         $('.image-mask-container').css('display', 'block');
//         $('.segment-masking-container').css('display', 'block');
//         if (dataPage == 'redesign' || dataPage == 'productSearch' || dataPage == 'sky-color' || dataPage == 'rostMyHome' || dataPage == 'collage_to_render') {
//             $('.redesign-designs-tabs').css('display', 'none');
//             $("#loading_brilliance").modal('hide');
//         }
//     }, 2000)
// });

$(".continue-parameter").click(function () {
    if (dataPage == 'collage_to_render'){
        if($(".custom_added_elements").length <= 0 && $(".existing_elements").length <= 0){
            let error_message = 'Please upload custom elements to proceed.';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            return;
        }

        const objects = paintingCollageStag.getObjects();
        currLoc = $(location).attr('href');
        if((currLoc.indexOf('room-blend') != -1) && (objects.length <= 1)){
            let error_message = 'Please add at least 1 Custom element to proceed.';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            return null;
        }

        $('.redesign-designs-tabs').css('display', 'none');
        $('.top-menu-bar-second').css('display', 'none');
        // $('.image-mask-container').css('display', 'none');
        $('.segment-masking-container').css('display', 'none');
        $('.top-menu-bar-third').css('display', 'flex');
        $('.image-container').css('display', 'block');
        $('.category-container').css('display', 'block');
    } else {
        $('.redesign-designs-tabs').css('display', 'none');
        $('.top-menu-bar-second').css('display', 'none');
        // $('.image-mask-container').css('display', 'none');
        $('.segment-masking-container').css('display', 'none');
        $('.top-menu-bar-third').css('display', 'flex');
        $('.image-container').css('display', 'block');
        $('.category-container').css('display', 'block');
    }
});

$(".previous_page").click(function () {
    if (dataPage == 'redesign' || $('.top-menu-bar-second').is(':visible')) {
        $('.redesign-designs-tabs').css('display', 'block');
        $('.top-menu-bar-second').css('display', 'none');
        $('.image-mask-container').css('display', 'none');
        $('.segment-masking-container').css('display', 'none');
        $('.top-menu-bar-first').css('display', 'flex');
        $('.upload-image-container').css('display', 'flex');
    } else if (dataPage == 'inPaint' || dataPage == 'decorstaging' || dataPage == 'fillSpace' || dataPage == 'change-colors-texture' || dataPage == 'productSearch' || dataPage == 'color_swap' || dataPage == 'style_transfer' || dataPage == 'collage_to_render') {
        if ($('.top-menu-bar-third').is(':visible')) {
            $('.redesign-designs-tabs').css('display', 'block');
            $('.top-menu-bar-third').css('display', 'none');
            $('.image-container').css('display', 'none');
            $('.category-container').css('display', 'none');
            $('.top-menu-bar-second').css('display', 'flex');
            $('.image-mask-container').css('display', 'block');
            $('.segment-masking-container').css('display', 'block');
        }
    }
});


function _generateFeedback(sec ,el){
    var imageType = document.getElementById('imageType').value;
    var image = document.getElementById('input_image').value;
    if (image == '') {
        alert("Make sure you add an Input Image!");
        $(el).attr('disabled', false);
        return;
    }
    if (imageType == null || imageType === "") {
        let error_message = 'Please select an Image Type!';
        $('#errorModal h4').text(error_message);
        $('#errorModal').modal('show');
        return;
    }
    $('#gen_spinner').removeClass('dis_spinner');
    $("#degn_btn_id").addClass('fur_find_disb');
    $('.displayImageFeedbackContainer').addClass('hidden')

    var formData = new FormData();
    formData.append('base64Image', image);
    formData.append('imageType', imageType);

    var route = $('#getImageFeedback').data('route');
    $.ajax({
        url: route,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#gen_spinner').addClass('dis_spinner');
            $("#degn_btn_id").removeClass('fur_find_disb');
            if (response.data.choices && response.data.choices.length > 0) {
                var content = response.data.choices[0].message.content;
                var feedbackList = content.split('\n').filter(line => line.trim().length > 0);

                var firstParagraph = `<p class="gs-roast-feebackvs-lis-titleinfo">${feedbackList.shift()}</p>`;
                var lastParagraph = `<p class="gs-roast-feebackvs-remember-text">${feedbackList.pop()}</p>`;

                var feedbackHtml = feedbackList.map((feedback, index) => {
                    var parts = feedback.split(': ');
                    if (parts.length > 1) {
                        return `<div class="gs-roast-feebackvs-list-step">
                                    <span class="gs-roast-feebackvs-list-step-number">${(index + 1).toString().padStart(2, '0')}</span>
                                    <p class="gs-roast-feebackvs-list-step-data"><strong>${parts[0]}:</strong> ${parts[1]}</p>
                                </div>`;
                    } else {
                        return `<div class="gs-roast-feebackvs-list-step">
                                    <p class="gs-roast-feebackvs-list-step-data"><strong>${parts[0]}</strong></p>
                                </div>`;
                    }
                }).join('');


                $('.gs-roast-feebackvs-titlebx').after(firstParagraph);
                $('.gs-roast-feebackvs-list').html(feedbackHtml);
                $('.gs-roast-feebackvs-list').after(lastParagraph);
                $('.displayImageFeedbackContainer').removeClass('hidden');
            } else {
                $('#displayImageFeedback').text('No feedback available.');
                $('.displayImageFeedbackContainer').removeClass('hidden');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error increasing count:', error);
        }
    });
}

$('.imageFeedbackCopy').click(function() {
    var feedbackText = $('#displayImageFeedback').text();
    var $textarea = $('#displayImageFeedback');
    $textarea.removeAttr('readonly').select();
    document.execCommand('copy');
    $textarea.attr('readonly', true);

    var $copyFeedbackContainer = $('.displayImageFeedbackContainer');
    $copyFeedbackContainer.addClass('active');
    setTimeout(function() {
        $copyFeedbackContainer.removeClass('active');
    }, 2500);

    return false; // Prevent default behavior of the anchor tag
});
// Add more images as needed
var editImagesData = [];
var currentIndex = 0;
// Function to update the images based on the current index
// Function to add a new design image at index 0
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

function loadImageBase64FromInpainting(base64Data) {
    let section = 0; // Assuming you have a way to determine section from URL
    $('#loading_brilliance').modal('show');

    let gallery = document.getElementById(`gallery${section}`);
    gallery.style.display = 'block';

    let img = document.createElement('img');
    img.src = base64Data;
    document.getElementById(`gallery${section}`).innerHTML = '';
    document.getElementById(`gallery${section}`).appendChild(img);
    $('#input_img_typ').val('base64');
    $('#input_image').val(base64Data);

    let furnitureFinderImg = document.querySelector('.gs-similar-product-img');
    if (furnitureFinderImg) {
        furnitureFinderImg.src = reader.result;
    }

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
        if (dataPage == 'redesign' || dataPage == 'productSearch' || dataPage == 'sky-color' || dataPage == 'rostMyHome' || dataPage == 'convenient-redesign') {
            $('.redesign-designs-tabs').css('display', 'none');
            $("#loading_brilliance").modal('hide');
        }
    }, 2000)
}

function generationDivLoader(noOfDesign,inputImage){
    var itemHtml = `
			<div class="snippet dot-in-paint-loader" data-title="dot-pulse">
                <div class="ai-upload-loader"><script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script><dotlottie-player src="https://lottie.host/68271c9d-441b-4c3e-b21f-726d10c3f490/vsHwnrlRvB.json" background="transparent" speed="1" style="width: 130px;   height: 130px;" loop autoplay></dotlottie-player>
                </div>
            </div>`;
    var loaderdata = document.getElementById(`all_data0`);
    for (let i = 0; i < noOfDesign; i++) {
        const newFreeformSpacer = document.createElement('div');
        newFreeformSpacer.className = 'col-md-6 col-lg-4 col-12';
        newFreeformSpacer.id = `progressindicatordiv${i}`;  // Ensure unique IDs if necessary

        const newDiv = document.createElement('div');
        newDiv.className = 'in-painting-card loader-card ai-upload-latest-single';
        newDiv.innerHTML = itemHtml;

        // Set the dynamic background image
        newDiv.style.backgroundImage = `url(${inputImage})`;

        newFreeformSpacer.appendChild(newDiv);
        loaderdata.insertBefore(newFreeformSpacer, loaderdata.firstElementChild);
    }
}

function removeLoaderDivs(noOfDesign) {
    var loaderdata = document.getElementById('all_data0');

    for (let i = 0; i < noOfDesign; i++) {
        const divToRemove = document.getElementById(`progressindicatordiv${i}`);
        if (divToRemove) {
            loaderdata.removeChild(divToRemove);
        }
    }
}

$('.first_tab_active').click(function () {
    $('.top-menu-bar-first').css('display', 'flex');
    $('.upload-image-container').css('display', 'flex');
    $('.searched_product_result').css('display', 'flex');
    $('.redesign-designs-tabs').css('display', 'block');

    $('.top-menu-bar-second').css('display', 'none');
    $('.image-mask-container').css('display', 'none');
    $('.segment-masking-container').css('display', 'none');

    $('.top-menu-bar-third').css('display', 'none');
    $('.image-container').css('display', 'none');
    $('.category-container').css('display', 'none');
});

$('.second_tab_active').click(function () {
    if(dataPage != 'redesign' && dataPage != 'rostMyHome' && dataPage != 'convenient-redesign' && dataPage != 'collage_to_render'){
        if (!imageLayer.hasChildren()) {
            let error_message = 'Make sure to Upload your Image!';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            return;
        }
    }
    if(dataPage == 'collage_to_render'){
        if(mainImage == undefined)
            {
                let error_message = 'Make sure to Upload your Image!';
                $('#errorModal h4').text(error_message);
                $('#errorModal').modal('show');
                return;
            }
    }
    if(dataPage == 'redesign' || dataPage == 'rostMyHome' || dataPage == 'convenient-redesign'){
        var image = document.getElementById('input_image').value;
        if (image == '') {
            let error_message = 'Make sure to Upload your Image!';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            return;
        }
    }

    $('.top-menu-bar-first').css('display', 'none');
    $('.upload-image-container').css('display', 'none');
    $('.searched_product_result').css('display', 'none');

    $('.top-menu-bar-second').css('display', 'flex');
    $('.image-mask-container').css('display', 'block');
    $('.segment-masking-container').css('display', 'block');
    $('.redesign-designs-tabs').css('display', 'block');
    if (dataPage == 'redesign' || dataPage == 'productSearch' || dataPage == 'sky-color' || dataPage == 'rostMyHome' || dataPage == 'collage_to_render') {
        $('.redesign-designs-tabs').css('display', 'none');
        $("#loading_brilliance").modal('hide');
    }
    $('.top-menu-bar-third').css('display', 'none');
    $('.image-container').css('display', 'none');
    $('.category-container').css('display', 'none');
});

$('.third_tab_active').click(function () {
    if (dataPage == 'collage_to_render'){
        if(mainImage == undefined)
            {
                let error_message = 'Make sure to Upload your Image!';
                $('#errorModal h4').text(error_message);
                $('#errorModal').modal('show');
                return;
            }
        if($(".custom_added_elements").length <= 0 && $(".existing_elements").length <= 0){
            let error_message = 'Please upload custom elements to proceed.';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            return;
        }

        const objects = paintingCollageStag.getObjects();
        currLoc = $(location).attr('href');
        if((currLoc.indexOf('room-blend') != -1) && (objects.length <= 1)){
            let error_message = 'Please add at least 1 Custom element to proceed.';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            return null;
        }
    }else{
        if (!imageLayer.hasChildren()) {
            let error_message = 'Make sure to Upload your Image!';
            $('#errorModal h4').text(error_message);
            $('#errorModal').modal('show');
            return;
        }
    }
    $('.top-menu-bar-first').css('display', 'none');
    $('.upload-image-container').css('display', 'none');
    $('.searched_product_result').css('display', 'none');

    $('.redesign-designs-tabs').css('display', 'none');
    $('.top-menu-bar-second').css('display', 'none');
    $('.segment-masking-container').css('display', 'none');

    $('.image-mask-container').css('display', 'block');
    $('.top-menu-bar-third').css('display', 'flex');
    $('.image-container').css('display', 'block');
    $('.category-container').css('display', 'block');
});

function disableGenerateButton(button, spinner,tabs,previousPageButton){
    button.classList.add('disabled');
    button.style.cursor = 'not-allowed';
    spinner.style.display = 'inline-block';
    spinner.style.cursor = 'not-allowed';
    tabs.forEach(tab => {
        tab.classList.add('disabled');
        tab.style.pointerEvents = 'none';
        tab.style.opacity = '0.6';
        tab.style.cursor = 'not-allowed';
    });
    previousPageButton.classList.add('disabled');
    previousPageButton.style.pointerEvents = 'none';
    previousPageButton.style.opacity = '0.6';
    previousPageButton.style.cursor = 'not-allowed';
}

function enableGenerateButton(button, spinner,tabs,previousPageButton) {
    button.classList.remove('disabled');
    button.style.cursor = 'pointer';
    spinner.style.display = 'none';
    spinner.style.cursor = 'pointer';
    tabs.forEach(tab => {
        tab.classList.remove('disabled');
        tab.style.pointerEvents = 'auto';
        tab.style.opacity = '1';
        tab.style.cursor = 'pointer';
    });
    previousPageButton.classList.remove('disabled');
    previousPageButton.style.pointerEvents = 'auto';
    previousPageButton.style.opacity = '1';
    previousPageButton.style.cursor = 'pointer';
}
