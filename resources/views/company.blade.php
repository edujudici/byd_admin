@extends('layouts.app')

@section('title', 'Company')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Company</li>
	</ol>
@endsection

@section('content')
    <div id="koCompany">
        <h1>New / Edit Company</h1>

        <form data-bind="with: company">
    		<div class="form-group">
                <label class="btn btn-info btn-file">
    	            <i class="fa fa-plus" aria-hidden="true"></i>
    	            Load Image <input type="file" hidden data-bind="event: {'change': function() { fileSelected($element); }}">
    	        </label>
                <div class="form-row">
                    <div class="col-md-6">
                        <img data-bind="attr: {src: image}" class="img-thumbnail rounded float-left" style="width: 200px; height: 200px">
                    </div>
                </div>
    		</div>
           
    		<div class="form-group">
    			<div class="form-row">
    				<div class="col-md-6">
    					<label for="txtAddress">Address</label>
    					<input class="form-control" id="txtAddress" type="text" placeholder="Enter address" data-bind="value: address">
    				</div>
    				<div class="col-md-6">
    					<label for="txtEmail">Email</label>
    					<input class="form-control" id="txtEmail" type="text" placeholder="Enter email" data-bind="value: email">
    				</div>
    			</div>
    		</div>

    		<div class="form-group">
    			<div class="form-row">
    				<div class="col-md-6">
    					<label for="txtPhone">Phone</label>
    					<input class="form-control" id="txtPhone" type="text" placeholder="Enter phone" data-bind="value: telephone">
    				</div>
    				<div class="col-md-6">
    					<label for="txtIframe">Iframe</label>
    					<input class="form-control" id="txtIframe" type="text" placeholder="Enter iframe" data-bind="value: iframe">
    				</div>
    			</div>
    		</div>
    		
            <div class="col-md-6 pull-left">
                    <a class="btn btn-primary btn-block" data-bind="click: cancel">Cancel</a>
                </div>
            <div class="col-md-6 pull-left">
                <a class="btn btn-primary btn-block" data-bind="click: save">Save</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

        var response =  {!! $response !!},
            urlCompanySave = "{{ route('company.save') }}";

        function Company(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.COM_ID;
            self.image = ko.observable();
            self.address  = ko.observable(obj.COM_ADDRESS).extend({
                required: {
                    params: true,
                    message: 'The file address is required'
                }
            });
            self.email  = ko.observable(obj.COM_EMAIL).extend({
                required: {
                    params: true,
                    message: 'The file email is required'
                }
            });
            self.telephone  = ko.observable(obj.COM_TELEPHONE).extend({
                required: {
                    params: true,
                    message: 'The file telephone is required'
                }
            });
            self.iframe  = ko.observable(obj.COM_IFRAME).extend({
                required: {
                    params: true,
                    message: 'The file iframe is required'
                }
            });            
            self.file  = ko.observable().extend({
                required: {
                    message: "The file field is required",
                    onlyIf: function() {
                        return !self.id;
                    }
                }
            });

            self.errors = ko.validation.group(self);

            self.setImage = function(data)
            {
                self.image(data);
            }

            self.loadImage = function(imageId)
            {
            	if (imageId)
                	Api.get(Api.url(imageId), self.setImage);                    
            }
            self.loadImage(obj.COM_IMAGE_ID);                      

            self.save = function()
            {
                infoAlert.error([]);
                if (self.errors().length > 0)
                {
                    infoAlert.error(self.errors());
                    return;
                }

                var formData = new FormData();
                    
                    if (self.id)
                        formData.append('id', self.id);

                    if (self.file())
                        formData.append('file', self.file());

                    formData.append('address', self.address());
                    formData.append('email', self.email());
                    formData.append('telephone', self.telephone());
                    formData.append('iframe', self.iframe());

                var callback = function(response)
                {
                    if(!response.status)
                    {
                        infoAlert.error([response.message]);
                        return;
                    }
                    else
                    {
                        self.id = response.data.COM_ID;
                        self.origin = response.data;
                        infoAlert.success();
                    }
                };
                Api.postImage(urlCompanySave, formData, callback);
            }

            self.goBackData = function()
            {
                var dataOld = new Company(self.origin);
                viewModel.company(dataOld);
            }

            self.cancel = function(item)
            {
                self.goBackData(item);
            }

            self.fileSelected = function(el) {
                
                if (el) {
                    
                    var counter = -1,
                        file,                        
                        imageCounter = 0;
                    while ( file = el.files[ ++counter ] ) {
                        
                        if(file.size > 10 * 1024 * 1024) {
                            infoAlert.error(['File too big.']);

                        } else {
                            var fileNamePieces = file.name.split('.');
                            var extension = fileNamePieces[fileNamePieces.length - 1];

                            if (extension != 'jpg' && extension != 'png' && extension != 'jpeg') {
                                infoAlert.error(['File invalid.']);
                                return;
                            }
                            
                            self.file(file);
                        }
                    }
                }                    
            }

            self.loadImageComp = ko.computed(function()
            {
                if (self.file())
                {
                    var url = URL.createObjectURL(self.file());
                    self.image(url);
                }
            });
        }

        function ViewModel()
        {
            var self = this;

            self.company = ko.observable();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.company(new Company(response.data || {}));
                }
            };
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koCompany'));
    </script>
@endsection