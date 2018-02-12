{{-- <div class="alert alert-success" id="info-alert">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <h4>Success</h4>
    <br />
    <div data-bind="text: message"></div>
</div> --}}

<script>

    function InfoAlert(){

        var self = this;

        self.message = ko.observable();
        self.hasError = ko.observable();

        self.success = function (message)
        {
            self.message(message ? message : 'All records were processed correctly!');
            
            // window.setTimeout(function () {
            //     $("#info-alert").fadeTo(500, 0).slideUp(500, function () {
            //         $(this).remove();
            //     });
            // }, 1000);
            $(".alert-success").fadeIn('fast');
            setTimeout(function()
            {
                $(".alert-success").fadeOut(300);
            }, 3000);
        }

        self.error = function(message)
        {
            if (!message.length)
            {
                self.hasError(false);
                return;
            }
            self.hasError(true);
            self.message(message.join('\n'));
        }
    }

    $(function()
    {
        infoAlert = new InfoAlert();
        ko.applyBindings(infoAlert, document.getElementById('info-alert'));
    });
</script>