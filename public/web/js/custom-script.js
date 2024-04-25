// const { preview } = require("vite");
const objectContainer = document.querySelector(".key-objects-result");
const projectButton = document.querySelector('.add_to_project_btn');
const deleteButton = document.querySelector('.delete_button');
const selectedImages = {};
var runpodName = 'first_runpod';
var runpodType = '1' ;
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
    if (confirm("Are you sure you want to logout?") == true) {
	window.indexedDB.deleteDatabase('fileDatabase');
        $("#logoutForm").submit();
    }
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
        $("#modalUpgradePlan").modal('show');
        return false;
    } else if (className == "paid_style_feature_modal") {
        $(this).find('option:not(.paid_style_feature_modal):eq(0)').prop('selected', true);
        $("#modalStyleUpgradePlan").modal('show');
        return false;
    } else if (className == "paid_roomtype_feature_modal") {
        $(this).find('option:not(.paid_roomtype_feature_modal):eq(0)').prop('selected', true);
        $("#modalRoomTypeUpgradePlan").modal('show');
        return false;
    }
})

$(".paid_feature_modal").click(function () {
    $("#modalUpgradePlan").modal('show');
})
$(".paid_style_feature_modal").click(function () {
    $("#modalStyleUpgradePlan").modal('show');
})
$(".paid_roomtype_feature_modal").click(function () {
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
    var leftSide = _createDesignItemBox(data.id, data.original_url, ['Before'], showButton, enhanceButton == false, isShowUseAsInput, isSelected = false, showHdButton = false, data.section, showDelBtn, precisionUpUser, isFavoriteVisible = false, showFavoriteBtn, favoriteImage,showHDIcon = false,hdImage);
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
    var rightSide = _createDesignItemBox(data.id, data.generated_url, rightOL, showButton, enhanceButton == true, isShowUseAsInput, isSelected = true, showHdButton = true, data.section, showDelBtn, precisionUpUser, isFavoriteVisible = true, showFavoriteBtn, favoriteImage,showHDIcon = true,hdImage,mode);

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

function _createDesignItemBox(id = null, imageUrl, styles = [], canDownload = true, enhanceButton, isShowUseAsInput, isSelected, showHdButton, section, showDelBtn, precisionUpUser, isFavoriteVisible, showFavoriteBtn, favoriteImage,showHDIcon = false,hdImage,mode = null) {

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
                    if(hdImage == 0){
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
        if(showHDIcon == true)
        {
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
    var sectionId = $(this).closest('.user_gallery_container').data('sec-id');

    $("#forminterior" + sectionId).find("[name='image_type']").val('url');
    $("#forminterior" + sectionId).find("[name='image']").val(image_url);

    let gallery = document.getElementById(`gallery${sectionId}`);
    gallery.style.display = 'block';

    let uploadText = document.getElementById(`uploadText${sectionId}`);
    uploadText.style.display = 'none';

    document.getElementsByClassName(`drop-cont${sectionId}`)[0].style.visibility = 'hidden';

    let img = document.createElement('img');
    img.src = image_url;
    document.getElementById(`gallery${sectionId}`)
        .removeChild(document.getElementById(`gallery${sectionId}`).firstElementChild);
    document.getElementById(`gallery${sectionId}`).appendChild(img);
    document.getElementById(`forminterior${sectionId}`).scrollIntoView();
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

$(".dimg-picker").on('change', function (e) {

    var filePicker = $(this);
    var files = filePicker[0].files;
    var section = filePicker.data('section');



    ipsValidateImage(files[0], () => {
        ipsPreviewImg(section);
    }, (error) => {
        ipsFailOnValidImage(error);
        filePicker.val('');
        $(`#gallery${section}`).hide();
        $(`#uploadText${section}`).removeAttr("style");
        $(`.drop-cont${section}`).removeAttr("style");
        $("#forminterior" + section).find("[name='image_type']").val('');
        $("#forminterior" + section).find("[name='image']").val('');
    });
});

$(".img-upload-outer").on('click touchstart', function () {
    var target = 'fileselect' + $(this).data('section');
    document.getElementById(target).click();
});


function ipsFailOnValidImage(error, min_height_width = 768) {
    if (error == 'type') {
        alert('Allowed Extensions are: jpeg, jpg and png.');
    }

    if (error == 'size') {
        let error_message = 'Minimum size should be ' + min_height_width + 'x' + min_height_width
        alert(error_message);
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

    var file = $("#fileselect" + section)[0].files[0];

    let gallery = document.getElementById(`gallery${section}`);
    gallery.style.display = 'block';

    let uploadText = document.getElementById(`uploadText${section}`);
    uploadText.style.display = 'none';

    document.getElementsByClassName(`drop-cont${section}`)[0].style.visibility = 'hidden';

    let reader = new FileReader()
    reader.readAsDataURL(file)
    reader.onloadend = function () {
        let img = document.createElement('img')
        img.src = reader.result
        document.getElementById(`gallery${section}`).removeChild(document.getElementById(`gallery${section}`)
            .firstElementChild);
        document.getElementById(`gallery${section}`).appendChild(img);
        $("#forminterior" + section).find("[name='image_type']").val('blob');
        $("#forminterior" + section).find("[name='image']").val(reader.result);
    }
}

const ipsValidateImage = (file, success, fail, min_height_width = 768) => {

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

function updateFastSpring(userDetail = null) {

    if (user) {
        fastspring.builder.recognize({
            "email": user.email,
        });
    }
}

function previewImage(src) {
    $("#modalImagePreview").modal('show')
    $("#mip").attr('src', src);
}
//get multiple images in array
var multipleDownloadImg = [];

function getMultipleImages(src) {
    if ($('.ml_dw_img').is(':checked') && !this.multipleDownloadImg.includes(src)) {
        this.multipleDownloadImg.push(src);
    } else {
        this.multipleDownloadImg.splice(this.multipleDownloadImg.indexOf(src), 1);
    }
    if (this.multipleDownloadImg.length > 0) {
        $(`.add_to_project_btn`).removeClass('hidden');
        $(`.delete_button`).removeClass('hidden');
        $(`.download_button`).removeClass('hidden');
        $(`.remove_image_from_folder_btn`).removeClass('hidden');
    } else {
        $(`.add_to_project_btn`).addClass('hidden');
        $(`.delete_button`).addClass('hidden');
        $(`.download_button`).addClass('hidden');
        $(`.remove_image_from_folder_btn`).addClass('hidden');
    }
}
//delete multiple images
function deleteMultipleImages() {

    var jsonData = JSON.stringify(this.multipleDownloadImg);
    var route = $('#deleteRenderImages').data('route');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    })
        .then((willDelete) => {
            if (willDelete.isConfirmed) {
                $.ajax({
                    url: route,
                    type: "POST",
                    data: {
                        images: this.multipleDownloadImg
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            'Your Images has been deleted.',
                            'success'
                        )
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000); //refresh every 2 seconds
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
            }
        });
}
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

function _showUsageMessage(updatedUsage) {

    if (updatedUsage.error_code == "individual_limit_crossed") {
        $("#modalIndividualLimit").modal('show');
    } else if (updatedUsage.error_code == "FREE_PLAN_LIMIT") {
        $("#limitCrossedMessage")
            .html("<strong>You do not have</strong> enough credits! Wait 24 hours for 3 new credits or <strong> <span class='st-b-ug-plan'> UPGRADE NOW </span> - Our Early Bird discount will expire soon. You'll never see these low prices again!</strong>")
            .show();

        if ($("#udFreeLimitCrossModal").length) {
            $("#udFreeLimitCrossModal").modal('show');
        }
    } else if (updatedUsage.error_code == "daily_fair_usage") {
        $("#modalDailyFairUsage").modal('show');
    } else if (updatedUsage.error_code == "DAILY_FREE_DISABLED") {
        $("#limitCrossedMessage")
            .html("Currently, new generations are disabled for free users.<span class='st-b-ug-plan'>Upgrade</span> to PRO to unlock UNLIMITED designs.")
            .show();
    } else {
        alert(updatedUsage.message);
    }

    var target = $('#buy');
    if (target.length) {
        $('html,body').animate({
            scrollTop: target.offset().top
        }, 100);
    }
}
var generationCount = 0;

async function _generateDesign(sec, el) {
    runpodType = '1' ;
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

    if(localStorage.getItem('filekey'+sec) !== undefined) {
        localStorage.removeItem('filekey'+sec);
        localStorage.removeItem('oldDetails');
    }
    var precisionUserValue = document.getElementById('precisionUser').value;
    var newGenerationCount = generationCount + 1;
    generationCount = newGenerationCount;
    if (newGenerationCount == 7) {
        $("#multipleGenaerationModal").modal('show');
    }

    //ajax call to increase count of btn according sec
    // const response = await $.ajax({
    //     type: 'POST',
    //     url: "route('admin.updateButtonClickCount')",
    //     data: {
    //         sec: sec
    //     },
    //     dataType: 'json',
    // });

    // if (response && response.message === 'Click count updated successfully') {
    //     // Click count updated successfully
    // } else {
    //     // Handle error
    //     console.error('Error updating click count');
    // }

    $(el).attr('disabled', true);
    var etaValue = 0.0;
    var cgsValue = 7.0;
    var negativeValue = "";
    var stepsValue = 40;

    var $container = $("#forminterior" + sec);
    let image_type = $container.find("[name='image_type'").val();
    let image = $container.find("[name='image'").val();

    if (image == '') {
        alert("Make sure you add an Input Image!");
        $(el).attr('disabled', false);
        return;
    }

    var isSubbed = false;
    var updatedUsage = await verifyPlan();

    if ((!updatedUsage) || !updatedUsage.status) {
        _showUsageMessage(updatedUsage);
        $(el).attr('disabled', false);
        return;
    }

    $.ajax({
        url: 'admin/dashboard/updateButtonClickCount',
        type: 'post',
        data: {
            sec: sec
        },
        dataType: 'json',
        success: function (resp) {
        },
        error: function (resp) {
            swal("Something Went Wrong!", {
                icon: "error",
            });
        }
    });

    //ajax code to store the count of styles
    var styleType = document.getElementById(`styleType${sec}`).value;
    var roomType = document.getElementById(`roomType${sec}`).value;
    var countStyles = {
        styleType: styleType,
        roomType: roomType,
        sec: sec
    };
    $.ajax({
        type: "POST",
        url: "admin/dashboard/updateButtonStyleClickCount",
        data: countStyles,
        success: function (response) {
        },
        error: function (xhr, status, error) {
        }
    });

    var numUserGens = updatedUsage.data.count;
    isSubbed = !updatedUsage.data.watermark;
    var watermark = updatedUsage.data.watermark;
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

    // Disable AI category Pill
    _updateAiCatePillsStatus('disable');

    document.getElementById(`hundredid${sec}`).click();

    var strengthType = document.getElementById(`strength${sec}`).value;
    var modeType = document.getElementById(`modeType${sec}`).value;
    var is_staging = (APP_LOCAL == 'production') ? 'false' : 'true';
    var noOfDesign = document.getElementById(`no_of_design${sec}`).value;
    var customInstructionData = document.getElementById(`custom_instruction${sec}`).value;
    var customInstruction = 0;
    if (document.getElementById(`nwcust${sec}`).checked === true) {
        customInstruction = 1;
    }

    var privatize = 0;
    if (document.getElementById(`nwtoggle${sec}`).checked === true) {
        privatize = 1;
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
    } else if(modeType == 'Sketch to Render'){
        // aiAPI = `${GPU_SERVER_HOST_INIT}/render_realistic?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&prompt=${styleType}&roomtype=${roomType}&prompt_modifier=${promptALL}&id=${user.uid}&designtype=${sec}&mobilecheck=${mobileCheck}&eta=${etaValue}&guidance_scale=${cgsValue}&negative_prompt=${negativeValue}&steps=${stepsValue}&strengthType=${strengthType}&modeType=${modeType}&privateId=${privatize}&numUserGens=${numUserGens}&isSubbed=${isSubbed}&superenhance=${superenhance}&watermark=${watermark}&image_type=${image_type}&is_staging=${is_staging}&is_custom_instruction=${customInstruction}&custom_instruction=${customInstructionData}&no_of_Design=${noOfDesign}`;

        aiAPI = "/runpod/render_realistic";
    } else {
        // aiAPI = `${GPU_SERVER_HOST_INIT}/homedesigns?init=https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1&prompt=${styleType}&roomtype=${roomType}&prompt_modifier=${promptALL}&id=${user.uid}&designtype=${sec}&mobilecheck=${mobileCheck}&eta=${etaValue}&guidance_scale=${cgsValue}&negative_prompt=${negativeValue}&steps=${stepsValue}&strengthType=${strengthType}&modeType=${modeType}&privateId=${privatize}&numUserGens=${numUserGens}&isSubbed=${isSubbed}&superenhance=${superenhance}&watermark=${watermark}&image_type=${image_type}&is_staging=${is_staging}&is_custom_instruction=${customInstruction}&custom_instruction=${customInstructionData}&no_of_Design=${noOfDesign}`;
        aiAPI = "/runpod/beautiful_redesign";
    }
    formData.append("data", image);
    formData.append("prompt", styleType);
    formData.append("roomtype", roomType);
    formData.append("prompt_modifier", promptALL);
    formData.append("designtype", sec);
    formData.append("mobilecheck", mobileCheck);
    formData.append("eta", etaValue);
    formData.append("guidance_scale", cgsValue);
    formData.append("negative_prompt", negativeValue);
    formData.append("steps", stepsValue);
    formData.append("strengthType", strengthType);
    formData.append("modeType", modeType);
    formData.append("privateId", privatize);
    formData.append("numUserGens", numUserGens);
    formData.append("isSubbed", isSubbed);
    formData.append("superenhance", superenhance);
    formData.append("watermark", watermark);
    formData.append("image_type", image_type);
    formData.append("is_staging", is_staging);
    formData.append("is_custom_instruction", customInstruction);
    formData.append("custom_instruction", customInstructionData);
    formData.append("no_of_Design", noOfDesign);
    formData.append("public", privatize);
    formData.append("runpod_name", runpodName);
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
            deleteButton.disabled = false;
            if (result.error) {
                alert(result.error);
                return;
            }
            genratedImage = result['Sucess']['generated_image'];
            orignalImage = result['Sucess']['original_image'];
                genratedImage.forEach(function (item) {
                    var data = document.getElementById(`all_data${sec}`);
                    var newFreeformSpacer = document.createElement('div');
                    data.insertBefore(newFreeformSpacer, data.firstChild);

                    var design = {
                        original_url: orignalImage,
                        generated_url: item,
                        style: styleType,
                        room_type: roomType,
                        mode: modeType,
                        show_data: true,
                        section: sec,
                        precisionUserValue: precisionUserValue,
                        private: privatize,
                        hd_image : 0,
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
            deleteButton.disabled = false;
            console.error('Error:', error);
        });

    var progressindicatordiv = document.getElementById(`progressindicatordiv`);
    progressindicatordiv.remove();

    $(el).attr('disabled', false);

    // Enable AI category Pill
    _updateAiCatePillsStatus('enable');
}

function customInstruction(sec) {
    var isCustomInstruction = document.getElementById(`nwcust${sec}`).checked;
    if (isCustomInstruction == true) {
        $(`#custom_instruction${sec}`).show();
        $("#customAiModal").modal('show');
    } else {
        $(`#custom_instruction${sec}`).val('').hide();
        $("#customAiModal").modal('hide');
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

function customInstruction(sec) {
    var isCustomInstruction = document.getElementById(`nwcust${sec}`).checked;
    if (isCustomInstruction == true) {
        $(`#custom_instruction${sec}`).show();
    } else {
        $(`#custom_instruction${sec}`).val('').hide();
    }
}

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
    runpodType = '1' ;
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

    var updatedUsage = await verifyPlan();

    if ((!updatedUsage) || !updatedUsage.status) {
        _showUsageMessage(updatedUsage);
        $(el).attr('disabled', false);
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
            var noOfDesign = '1' ;

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
            // console.log(aiAPI);
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
                    deleteButton.disabled = false;

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
                                hd_image : 0,
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
                    deleteButton.disabled = false;
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

    runpodType = '1' ;
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
            console.log(resp.runpodName);
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

    var updatedUsage = await verifyPlan();

    if ((!updatedUsage) || !updatedUsage.status) {
        _showUsageMessage(updatedUsage);
        $(el).attr('disabled', false);
        return;
    }

    var precisionUserValue = document.getElementById('precisionUser').value;
    var sec = $(this).data('sec');
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

    // Disable AI category Pill
    _updateAiCatePillsStatus('disable');

    document.getElementById(`hundredid${sec}`).click();
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
                $('.ultra-enhancer').removeClass('disable-btn');
                $('.full_hd_quality').removeClass('disable-btn');
                $('._btn_gndeisgn').removeClass('disable-btn');
                $('.precision_btn').removeClass('disable-btn');
                document.getElementById(`progid`).style.display = 'none';
            }else{
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
                        $('.ultra-enhancer').removeClass('disable-btn');
                        $('.full_hd_quality').removeClass('disable-btn');
                        $('._btn_gndeisgn').removeClass('disable-btn');
                        $('.precision_btn').removeClass('disable-btn');
                        projectButton.disabled = false;
                        deleteButton.disabled = false;
                        var generated_image = result['Sucess']['generated_image'][0];
                        var original_image = result['Sucess']['original_image'];
                        var data = document.getElementById(`all_data${sec}`);
                        var newFreeformSpacer = document.createElement('div');
                        data.insertBefore(newFreeformSpacer, data.firstChild);

                        var design = {
                            original_url: original_image,
                            generated_url: generated_image,
                            style: resp.data.style,
                            room_type: resp.data.room_type,
                            mode: resp.data.mode,
                            show_data: true,
                            section: sec,
                            private: resp.data.privateId,
                            precisionUserValue: precisionUserValue,
                            hd_image : 1,
                        }

                        var code = createDesignItem(design);

                        var data = document.getElementById(`all_data${sec}`);
                        document.getElementById(`progid`).style.display = 'none';

                        var newFreeformSpacer = document.createElement('div');
                        newFreeformSpacer.innerHTML = code;
                        data.insertBefore(newFreeformSpacer, data.firstChild);

                        // Enable AI category Pill
                        _updateAiCatePillsStatus('enable');
                    })
                    .catch(error => {
                        $('.ultra-enhancer').removeClass('disable-btn');
                        $('.full_hd_quality').removeClass('disable-btn');
                        $('._btn_gndeisgn').removeClass('disable-btn');
                        $('.precision_btn').removeClass('disable-btn');
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

function changeMode(sec) {
    var modeValue = document.getElementById(`modeType${sec}`);
    var selectedOption = modeValue.options[modeValue.selectedIndex].value;
    // var strengthValue = document.getElementById(`strength${sec}`);
    var rangeInput = document.getElementById(`rangeInput${sec}`);
    $.each($(".dash-link"), function(){
        if($(this).hasClass('active')){
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
        $.each($(".dash-link"), function(){
            if($(this).hasClass('active')){
                $("#sidebarmodule").val($(this).attr('tag'));
            }
        });
    }

    // add tab module from interior, exterior and Gardens
    $.each($(".nwai-tab"), function(){
        if($(this).hasClass('active')){
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
        module:sidebarmodule,
        module_category:module_category
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
            if(response.success){
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
                aiAPI = `${API_GPU_SERVER_HOST}/get_token`;
                var payload = {
                    "name": user_name,
                    "email": user_email,
                };
                fetch(aiAPI, {
                    method: 'POST',
                    headers: {
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
    var routeURL = document.getElementById('editAsPrecision').getAttribute('data-route');

    $('.ultra-enhancer').addClass('disable-btn');
    $('.full_hd_quality').addClass('disable-btn');
    $('._btn_gndeisgn').addClass('disable-btn');
    $('.precision_btn').addClass('disable-btn');

    $.ajax({
        type: 'POST',
        url: routeURL,
        data: { img: img },
        success: function (response) {
            // if (response && response.b64image) {
            //     var b64image = 'data:image/png;base64,' + response.b64image;
            //     sessionStorage.setItem('b64image', b64image);
            //     setImageCache(b64image, function(response, error){
            //         if(response.success){
            //             // Redirect to the 'precision+' route
            //             window.location.href = '/user/precision?imageCacheId='+response.image_cache_id;
            //         }
            //     });
            // }
            if(response.success){
                // Redirect to the 'precision+' route
                window.location.href = '/user/precision?imageCacheId='+response.image_cache_id;
            }
        },
        error: function (error) {
            console.error('AJAX error:', error);
        }
    });
});
$("#closeserveyModal").click(function() {
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

$("#closeSuggestionPrecisionModal").click(function () {
    $("#suggestionPrecisionModal").hide();
});

async function addRemovefavorite(src) {
    const imageElement = document.getElementsByClassName(`favoriteImage${src}`);
    const hideImageElemnt = document.getElementById(`favoriteImage${src}`);
    $.ajax({
        url: SITE_BASE_URL + 'updateFavorite',
        type: "POST",
        data: {
            image: src
        },
        success: function (response) {
            if (response != null) {
                if (response.is_favorite) {
                    for (let i = 0; i < imageElement.length; i++) {
                        imageElement[i].src = '/web/images/red_heart.png';
                    }
                }
                else {
                    for (let i = 0; i < imageElement.length; i++) {
                        imageElement[i].src = '/web/images/white_heart.png';
                    }
                    if(hideImageElemnt){
                        $(hideImageElemnt).hide();
                        multipleDownloadImg.splice(multipleDownloadImg.indexOf(src), 1);

                        if (multipleDownloadImg.length > 0) {
                            $(`.delete_button`).removeClass('hidden');
                            $(`.download_button`).removeClass('hidden');
                        } else {
                            $(`.delete_button`).addClass('hidden');
                            $(`.download_button`).addClass('hidden');
                        }
                    }
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
    if(search_img){
        loadSearchImg(search_img);
        sessionStorage.removeItem('search_img');
    }
    if(window.innerWidth < 991){
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
        if (feedbackModalClosedCount < 3) {
            $("#feedbackModel").hide();
            if(feedbackModalClosedCount == 2){
                var route = $('#feedbackModelRoute').data('route');
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: { },
                    success: function (response) {
                    },
                    error: function (xhr, status, error) {
                        console.error('Error increasing count:', error);
                    }
                });
            }
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
})

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
                Swal.fire(
                    'Added!',
                    'Your Images has been added successfully!',
                    'success'
                )
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
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
    $('#create-sub-project-btn').text('Create');
    $("#createSubProjectModel").modal('show');
})

function editProject(projectID) {
    $("#createProjectForm")[0].reset();
    $("#createProjectForm").validate().resetForm();
    var editRoute = $('#editProjectRoute').data('route');
    $('#modalTitle').text('Edit Project');
    var updateRoute = $('#updateProjectRoute').data('route');
    $('#createProjectForm').attr('action', updateRoute.replace('__ID__', projectID));
    $('#createProjectForm').append('<input type="hidden" name="_method" value="PUT">');
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
    $('#create-project-btn').text('Update');
    $('#createProjectModel').modal('show');
}

function deleteProject(projectID) {
    var deleteRoute = $('#deleteProjectRoute').data('route');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    })
        .then((willDelete) => {
            if (willDelete.isConfirmed) {
                $.ajax({
                    url: deleteRoute.replace('__ID__', projectID),
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            'Your Project has been deleted.',
                            'success'
                        )
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function (xhr, status, error) {
                        var error = error.responseJSON;
                        console.log(error);
                        Swal.fire(
                            'Oops!',
                            error.message,
                            'warning'
                        )
                    }
                });
            }
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
    $('#create-sub-project-btn').text('Update');
    $('#createSubProjectModel').modal('show');
}

function deleteSubProject(subProjectID) {
    var deleteRoute = $('#deleteSubProjectRoute').data('route');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    })
        .then((willDelete) => {
            if (willDelete.isConfirmed) {
                $.ajax({
                    url: deleteRoute.replace('__ID__', subProjectID),
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            'Your Sub Project has been deleted.',
                            'success'
                        )
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function (xhr, status, error) {
                        var error = error.responseJSON;
                        console.log(error);
                        Swal.fire(
                            'Oops!',
                            error.message,
                            'warning'
                        )
                    }
                });
            }
        });
}

function removeImagesFromFolder(projectId, subProjectId) {
    var removeImagesRoute = $('#removeImagesFromFolder').data('route');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    })
        .then((willDelete) => {
            if (willDelete.isConfirmed) {
                $.ajax({
                    url: removeImagesRoute,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        images: this.multipleDownloadImg,
                        projectId: projectId,
                        subProjectId: subProjectId,
                    },
                    success: function (response) {
                        Swal.fire(
                            'Removed!',
                            'Your Images has been removed.',
                            'success'
                        )
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
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
            }
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

async function _generateProducts(sec ,el){
    $("#keyBars").hide();
    $(".product-results").hide();
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
        if(result['error']){
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
                success: function(response) {
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
                    var keyBarsHtml = '<div class="key-bar active" data-key="all">All</div>';

                    barKeys.forEach(function (formattedKey) {
                        var originalKey = keyMap[formattedKey]; // Retrieve the original key from the map

                        // Add styling to each key bar
                        keyBarsHtml += '<div class="key-bar" data-key="' + originalKey + '">' + formattedKey + '</div>';
                    });

                    // Append filter bar html
                    // keyBarsHtml += '<div class="form-check form-switch pull-right">';
                    // keyBarsHtml += '<input class="form-check-input" type="checkbox" id="enable_location" name="enable_location" value="'+response.currencyCymbol+'">';
                    // keyBarsHtml += '<label class="form-check-label text-white" for="enable_location">Only your location</label>';
                    // keyBarsHtml += '</div>';
                    // Append the key bars container to the #keyBars container
                    $('#keyBars').html(keyBarsHtml);

                    $('#enable_location').change(function() {
                        if ($(this).is(':checked')) {
                            let currency = $(this).val();
                            // hide other currency card if checkbox is checked
                            $(".product-card").hide();
                            $("."+currency).show();
                        } else {
                            // show all cards if checkbox is unchecked
                            $(".product-card").show();
                        }
                    });
                    // Initial display with "All" as active
                    displayResults('all', resultArray);
                },
                error: function(error) {
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
$(document).on('click', '.key-bar', function () {
    // Remove active class from all key bars
    $('.key-bar').removeClass('active');

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
    if(selectedKey == 'all'){
        Object.values(resultArray).forEach(function (keyItems) {
            // Concatenate the items of the current key to filteredResults
            filteredResults = filteredResults.concat(keyItems);
        });
    }else{
        filteredResults = resultArray[selectedKey];
    }
    // Generate HTML for the filtered results
    cardsHtml += '<div class="row">';

    filteredResults.forEach(function (item, index) {
        // Open a new row for every 6 cards
        // if (index % 6 === 0) {
        //     cardsHtml += '<div class="row">';
        // }

        cardsHtml += '<div class="col-lg-2 col-md-3 col-sm-6 col-12 mb-4 product-card">'; // Use col-md-2 for 6 cards in a row
        cardsHtml += '<div class="card h-100">';
        cardsHtml += '<img src="' + item.thumbnail + '" class="card-img-top" alt="' + item.title + '" style="height: 150px; object-fit: cover;">'; // Adjust the height and use object-fit
        cardsHtml += '<div class="card-body text-center flex-grow-1">';
        // Check if the title length is greater than 40
        if (item.title.length > 40) {
            // If it is, take the first 39 characters and add three dots
            var truncatedTitle = item.title.substring(0, 39) + '...';
            cardsHtml += '<h5 class="card-title" style="font-size: 15px;">' + truncatedTitle + '</h5>';
        } else {
            // If not, use the original title
            cardsHtml += '<h5 class="card-title" style="font-size: 15px;">' + item.title + '</h5>';
        }
        cardsHtml += '<div class="source-info">';
        cardsHtml += '<img src="' + item.source_icon + '" alt="' + item.source + '" style="height: 20px; width: 20px;">';
        cardsHtml += '<p class="source-text">' + item.source + '</p>';
        cardsHtml += '</div>';

        if (item.link) {
            cardsHtml += '<a href="' + item.link + '" class="btn btn-primary d-block mx-auto mt-auto" target="_blank">Buy Now</a>';
        }

        if (item.price) {
            cardsHtml += '<p class="card-text text-center">' + item.price.value + '</p>';
        } else {
            cardsHtml += '<p class="card-text text-center">No price available</p>';
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
    var convertedParts = parts.map(function(part) {
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

function loadSearchImg(search_img){
        var section = 0 ;
        var sectionId = section;
        let gallery = document.getElementById(`gallery${sectionId}`);
        gallery.style.display = 'block';

        let uploadText = document.getElementById(`uploadText${sectionId}`);
        uploadText.style.display = 'none';

        document.getElementsByClassName(`drop-cont${sectionId}`)[0].style.visibility = 'hidden';
        let img = document.createElement('img')

        if(search_img){
            img.src = search_img
        }
        document.getElementById(`gallery${section}`).removeChild(document.getElementById(`gallery${section}`)
            .firstElementChild);
        document.getElementById(`gallery${section}`).appendChild(img);
        $("#forminterior" + section).find("[name='image_type']").val('blob');
        $("#forminterior" + section).find("[name='image']").val(search_img);
        _generateProducts(0,this);
}

let copyText = document.querySelector(".upgrade_yearly_text");
if(copyText){
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
        data: { },
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


function setImageCache(base64Image, callback){
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
        error: function (error){
            callback(error);
        }
    });
}
