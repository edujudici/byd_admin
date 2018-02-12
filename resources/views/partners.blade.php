@extends('layouts.app')

@section('title', 'Partners')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Partners</li>
	</ol>
@endsection

@section('content')
    <div id="koPartner">
        <!-- ko with: partner -->
        <div data-bind="visible: $root.partner" style="display: none">
            <h1>New / Edit Partner</h1>
            <form>
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
	        			<label for="txtLink">Link</label>
	        			<input class="form-control" id="txtLink" type="text" placeholder="Enter Link" data-bind="value: link">
        			</div>
        		</div>
        		
                <div class="col-md-6 pull-left">
                    <a class="btn btn-primary btn-block" data-bind="click: cancel">Cancel</a>
                </div>
                <div class="col-md-6 pull-right">
                    <a class="btn btn-primary btn-block" data-bind="click: save">Save</a>
                </div>
            </form>
        </div>
        <!-- /ko -->
        
        <div data-bind="visible: !partner()" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addPartner">New Partner</a>
                </div>
            </div>

            <div class="row" style="margin-top: 15px">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%" style="min-width: 50px"></th>
                                <th width="30">Link</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: partners">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: link"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

        var response =  {!! $response !!},
            urlPartnerSave = "{{ route('partner.save') }}",
            urlPartnerDelete = "{{ route('partner.delete') }}";

        function Partner(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.PAR_ID;
            self.link  = ko.observable(obj.PAR_LINK);
            self.image = ko.observable();
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
            self.loadImage(obj.PAR_IMAGE_ID);          

            self.edit = function()
            {
            	viewModel.partner(self);
            }

            self.remove = function(item)
            {
            	confirmModal.show(
                    'Do you really want to delete this item?',
                    function() {            

                        var data =
                        {
                            id : item.id,
                        },
                        callback = function(response)
                        {
                            if(!response.status)
                            {
                                infoAlert.error([response.message]);
                                return;
                            }
                            else
                            { 
                                viewModel.partners.remove(item);
                                infoAlert.success(response.message);
                            }
                        };
                        Api.post(urlPartnerDelete, data, callback);
                    }
                );
            }

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

                    formData.append('link', self.link());

                var callback = function(response)
                {
                    if(!response.status)
                    {
                        infoAlert.error([response.message]);
                        return;
                    }
                    else
                    {
                        self.id = response.data.PAR_ID;
                        self.origin = response.data;
                        viewModel.partner(null);
                        infoAlert.success();
                    }
                };
                Api.postImage(urlPartnerSave, formData, callback);
            }

            self.goBackData = function(item)
            {
                var dataOld = new Partner(self.origin),
                    position = viewModel.partners.indexOf(item);
                viewModel.partners.splice(position,1,dataOld);
            }

            self.cancel = function(item)
            {
                if (!item.id)
                    viewModel.partners.remove(item);
                else
                    self.goBackData(item);
                viewModel.partner(null);                
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

            self.partners = ko.observableArray();
            self.partner = ko.observable();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.partners(ko.utils.arrayMap(response.data, function(obj) {
                        return new Partner(obj);
                    }));
                }
            };

            self.addPartner = function()
            {
            	var partner = new Partner({});
            	self.partners.push(partner);
            	partner.edit();
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koPartner'));
    </script>
@endsection