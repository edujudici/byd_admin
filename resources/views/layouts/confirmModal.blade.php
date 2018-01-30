<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" data-bind="click: confirm">Confirm</a>
            </div>
        </div>
    </div>
</div>

<script>

    function ConfirmModal(){
        var self = this;
        self.message = ko.observable();
        
        self.confirm = null;

        self.show = function (message, callback)
        {
            self.message(message ? messsage : 'Confirm this action?');
            
            self.confirm = callback != undefined 
            ?   function () 
                {
                    callback();
                    $('#confirmModal').modal('hide');
                } 
            :  function()
            {
                $('#confirmModal').modal('hide');
            }
            
            $('#confirmModal').modal('show');
        }
    }

    $(function()
    {
        confirmModal = new ConfirmModal();
        ko.applyBindings(confirmModal, document.getElementById('confirmModal'));
    });
</script>