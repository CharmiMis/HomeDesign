<div class="ips-colorpicker" id="ips-colorpicker-container">
    <div class="cp-icon" id="elColorPicker">
        <i class="fa fa-pencil fa-unset"></i>
    </div>
    <div class="cp-code" id="color-picker-code">#FFFFFF</div>
</div>

@push('script-stack')
    <script>
        let eyedropperButton = document.querySelector("#elColorPicker");

        function pickColorSetup() {
            if (window.EyeDropper === undefined) {
                return;
            }
            $("#ips-colorpicker-container").addClass('d-flex');
            eyedropperButton.addEventListener("click", pickColor, false);
        }

        pickColorSetup();

        async function pickColor(event) {

            let eyeDropper = new EyeDropper();
            try {
                let pickedColor = await eyeDropper.open();
                $("#color-picker-code").html(pickedColor.sRGBHex).addClass('d-flex');
            } catch (error) {}
        }
    </script>
@endpush
