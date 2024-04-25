function ipsToggleStrength(sec) {

    try {
        $("#extrasettings" + sec).toggleClass('d-none');
    } catch (error) {

    }

}

const ipsHideGeneratedOutput = (sec) => {
    var x = document.getElementById(`forminterior${sec}`);
    x.style.display = "block";
    var x = document.getElementById(`forminteriorbut${sec}`);
    x.style.display = "block";

    var x = document.getElementById(`logoset${sec}`);
    x.style.display = "block";

    document.getElementById('jumphere').scrollIntoView();

    var x = document.getElementById(`navtabs1`);
    x.style.display = "block";

    var x = document.getElementById(`textoutput${sec}`);
    x.style.display = "none";
    var x = document.getElementById(`generated_im_class${sec}`);
    x.style.display = "none";

};