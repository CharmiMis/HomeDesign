new WOW().init();


function openNav() {
    document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

// Animate words in home page hero section
var words = document.getElementsByClassName('word');
var wordArray = [];
var currentWord = 0;
if(words.length > 0){
    words[currentWord].style.opacity = 1;
    for (var i = 0; i < words.length; i++) {
        splitLetters(words[i]);
    }

    function changeWord() {
        var cw = wordArray[currentWord];
        var nw = currentWord == words.length - 1 ? wordArray[0] : wordArray[currentWord + 1];
        for (var i = 0; i < cw.length; i++) {
            animateLetterOut(cw, i);
        }

        for (var i = 0; i < nw.length; i++) {
            nw[i].className = 'letter behind';
            nw[0].parentElement.style.opacity = 1;
            animateLetterIn(nw, i);
        }

        currentWord = (currentWord == wordArray.length - 1) ? 0 : currentWord + 1;
    }
    function animateLetterOut(cw, i) {
        setTimeout(function() {
            cw[i].className = 'letter out';
        }, i * 80);
    }
    
    function animateLetterIn(nw, i) {
        setTimeout(function() {
            nw[i].className = 'letter in';
        }, 340 + (i * 80));
    }
    
    function splitLetters(word) {
        var content = word.innerHTML;
        word.innerHTML = '';
        var letters = [];
        for (var i = 0; i < content.length; i++) {
            var letter = document.createElement('span');
            letter.className = 'letter';
            letter.innerHTML = content.charAt(i);
            word.appendChild(letter);
            letters.push(letter);
        }
    
        wordArray.push(letters);
    }
    changeWord();
    setInterval(changeWord, 4000);
}
//End animate words in home page hero section





// toggle cards price

// 1ST CARD
// var chk = document.querySelector('#chk');
// var header = document.querySelector('#price1');

// chk.addEventListener('change', function(e) {
//     if (chk.checked)
//     //if checked yearly
//         header.innerHTML = "$40";
//     // else monthly
//     else
//         header.innerHTML = "$19";
// });


// // 2ND CARD
// var chk = document.querySelector('#chk');
// var header2 = document.querySelector('#price2');

// chk.addEventListener('change', function(e) {
//     if (chk.checked)
//     //if checked yearly
//         header2.innerHTML = "$79";
//     // else monthly
//     else
//         header2.innerHTML = "$27";
// });


// // 3RD CARD
// var chk = document.querySelector('#chk');
// var header3 = document.querySelector('#price3');

// chk.addEventListener('change', function(e) {
//     if (chk.checked)
//     //if checked yearly
//         header3.innerHTML = "$109";
//     // else monthly
//     else
//         header3.innerHTML = "$67";
// });

var loginModel = document.getElementById("loginModel");
var modal23 = document.getElementById("myModal2");
var modalStore = document.getElementById("modalStore");
var span = document.getElementsByClassName("close")[0];

$('#roomType0').on("change", function(){
    setOldSelectedValues();
});

$('#modeType0').on("change", function(){
    setOldSelectedValues();
});

$('#styleType0').on("change", function(){
    setOldSelectedValues();
});

$('#no_of_design0').on("change", function(){
    setOldSelectedValues();
});

$('#rangeInput0').on("change", function(){
    setOldSelectedValues();
});

$('#custom_instruction0').on("change", function(){
    setOldSelectedValues();
});

$('#roomType1').on("change", function(){
    setOldSelectedValues();
});

$('#modeType1').on("change", function(){
    setOldSelectedValues();
});

$('#styleType1').on("change", function(){
    setOldSelectedValues();
});

$('#no_of_design1').on("change", function(){
    setOldSelectedValues();
});

$('#rangeInput1').on("change", function(){
    setOldSelectedValues();
});

$('#custom_instruction1').on("change", function(){
    setOldSelectedValues();
});

$('#roomType2').on("change", function(){
    setOldSelectedValues();
});

$('#modeType2').on("change", function(){
    setOldSelectedValues();
});

$('#styleType2').on("change", function(){
    setOldSelectedValues();
});

$('#no_of_design2').on("change", function(){
    setOldSelectedValues();
});

$('#rangeInput2').on("change", function(){
    setOldSelectedValues();
});

$('#custom_instruction2').on("change", function(){
    setOldSelectedValues();
});


function showLoginModal(section = '') {
    setOldSelectedValues();
    $("#loginModel").show();
}

function setOldSelectedValues(){
    // Start Old selected values
    let details = {
        // Interior
        room_type0: $('#roomType0').val() ?? '',
        mode0: $('#modeType0').val() ?? '',
        design_style0: $('#styleType0').val() ?? '',
        number_of_designs0: $('#no_of_design0').val() ?? '',
        ai_intervention0: $('#rangeInput0').val() ?? '',
        custom_ai_instructions0: $('#custom_instruction0').val() ?? '',
        // Exterior
        room_type1: $('#roomType1').val() ?? '',
        mode1: $('#modeType1').val() ?? '',
        design_style1: $('#styleType1').val() ?? '',
        number_of_designs1: $('#no_of_design1').val() ?? '',
        ai_intervention1: $('#rangeInput1').val() ?? '',
        custom_ai_instructions1: $('#custom_instruction1').val() ?? '',
        // Garden
        room_type2: $('#roomType2').val() ?? '',
        mode2: $('#modeType2').val() ?? '',
        design_style2: $('#styleType2').val() ?? '',
        number_of_designs2: $('#no_of_design2').val() ?? '',
        ai_intervention2: $('#rangeInput2').val() ?? '',
        custom_ai_instructions2: $('#custom_instruction2').val() ?? ''
    }
    let detailString = JSON.stringify(details);
    localStorage.setItem('oldDetails', detailString);

    // Old Old selected values
}

function closeModal() {
    $("#loginModel").hide();
}

function closeModalStore() {
    modalStore.style.display = "none";
}