<!-- Start Provely Tracking Script -->
<script>
    (function(w, n) {
        if (typeof(w[n]) == 'undefined') {
            ob = n + 'Obj';
            w[ob] = [];
            w[n] = function() {
                w[ob].push(arguments);
            };
            d = document.createElement('script');
            d.source = 'text/javascript';
            d.async = 1;
            d.src = 'https://provely-public.s3.amazonaws.com/scripts/provely.js';
            x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(d, x);
        }
    })(window, 'provelys');
    provelys('config', 'baseUrl', 'https://app.provely.io');
    provelys('track', 'uuid', '495bfa80-320d-46dc-adc2-a40aadf091d6');
</script>
<!-- End Provely Tracking Script -->


<!-- Start Provely Notification Display Script -->
<script>
    (function(w, n) {
        if (typeof(w[n]) == 'undefined') {
            ob = n + 'Obj';
            w[ob] = [];
            w[n] = function() {
                w[ob].push(arguments);
            };
            d = document.createElement('script');
            d.type = 'text/javascript';
            d.async = 1;
            d.src = 'https://provely-public.s3.amazonaws.com/scripts/provely.js';
            x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(d, x);
        }
    })(window, 'provelys');
    provelys('config', 'baseUrl', 'https://app.provely.io');
    provelys('config', 'uuid', '495bfa80-320d-46dc-adc2-a40aadf091d6');
    provelys('config', 'showWidget', 1);
</script>
<!-- End Provely Notification Display Script -->
