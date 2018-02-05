@extends('layouts.app')

@section('title', 'Banner')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Banner</li>
	</ol>
@endsection

@section('content')
    <div id="koBanner">
        <!-- ko with: banner -->
        <div data-bind="visible: $root.banner" style="display: none">
            <h1>New / Edit Banner</h1>
            <form>
        		<div class="form-group">
        			<label class="btn btn-info btn-file">
        	            <i class="fa fa-plus" aria-hidden="true"></i>
        	            Load Image <input type="file" hidden data-bind="event: {'change': function() { fileSelected($element); }}">
        	        </label>
        		</div>
        		<div class="form-group">
        			<div class="form-row">
        				<div class="col-md-6">
        					<label for="txtTitle">Title</label>
        					<input class="form-control" id="txtTitle" type="text" placeholder="Enter title" data-bind="value: title">
        				</div>
        				<div class="col-md-6">
        					<label for="txtDescription">Description</label>
        					<input class="form-control" id="txtDescription" type="text" placeholder="Enter description" data-bind="value: description">
        				</div>
        			</div>
        		</div>
        		<div class="form-group">
        			<label for="txtLink">Link</label>
        			<input class="form-control" id="txtLink" type="text" placeholder="Enter Link" data-bind="value: link">
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
        
        <div data-bind="visible: !banner()">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addBanner">New Banner</a>
                </div>
            </div>

            <div class="row" style="margin-top: 15px">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%" style="min-width: 50px"></th>
                                <th width="30%">Title</th>
                                <th width="30">Description</th>
                                <th width="30">Link</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: banners">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: title"></span></td>
                                <td><span data-bind="text: description"></span></td>
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
            urlBannerSave = "{{ route('banner.save') }}",
            urlBannerDelete = "{{ route('banner.delete') }}";

        function Banner(obj)
        {
            var self = this;

            self.orign = obj;

            self.id    = obj.BAN_ID;
            self.link  = ko.observable(obj.BAN_LINK);
            self.image = ko.observable();
            self.file  = ko.observable();
            self.title = ko.observable(obj.BAN_TITLE).extend({
                required: {
                    params: true,
                    message: 'The title field is required'
                }
            });
            self.description = ko.observable(obj.BAN_DESCRIPTION).extend({
                required: {
                    params: true,
                    message: 'The description field is required'
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
            self.loadImage(obj.BAN_IMAGE_ID);          

            self.edit = function()
            {
            	viewModel.banner(self);
            }

            self.remove = function(item)
            {
            	confirmModal.show(
                    'Do you really want to delete this item?',
                    function() {            

                        var data =
                        {
                            id : item.id,
                            _token: '{{ csrf_token() }}',
                        },
                        callback = function(response)
                        {
                            if(!response.status)
                            {
                                alert(response.message);
                                return;
                            }
                            else
                            { 
                                viewModel.banners.remove(item);
                                alert(response.message);
                            }
                        };
                        Api.post(urlBannerDelete, data, callback);
                    }
                );
            }

            self.save = function()
            {
                if (self.errors().length > 0)
                {
                    alert(self.erros());
                    return;
                }

                var formData = new FormData();
                    
                    if (self.id)
                        formData.append('id', self.id);

                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('title', self.title());
                    formData.append('description', self.description());
                    formData.append('link', self.link());
                    formData.append('file', self.file());

                var callback = function(response)
                {
                    if(!response.status)
                    {
                        self.id = response.data.BAN_ID;
                        alert(response.message);
                        return;
                    }
                    else
                    {
                        self.id = response.data.BAN_ID;
                        alert('save success');
                    }
                };
                Api.postImage(urlBannerSave, formData, callback);
            }

            self.fileSelected = function(el) {
                
                if (el) {
                    
                    var counter = -1,
                        file,                        
                        imageCounter = 0;
                    while ( file = el.files[ ++counter ] ) {
                        
                        if(file.size > 10 * 1024 * 1024) {
                            alert('File too big.');

                        } else {
                            var fileNamePieces = file.name.split('.');
                            var extension = fileNamePieces[fileNamePieces.length - 1];

                            if (extension != 'jpg' && extension != 'png' && extension != 'jpeg') {
                                alert('File invalid.');
                                return;
                            }
                            
                            self.file(file);
                        }
                    }
                }                    
            }

            self.cancel = function()
            {
                viewModel.banner(null);
            }
        }

        function ViewModel()
        {
            var self = this;

            self.banners = ko.observableArray();
            self.banner = ko.observable();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.banners(ko.utils.arrayMap(response.data, function(obj) {
                        return new Banner(obj);
                    }));
                }
            };

            self.addBanner = function()
            {
            	var banner = new Banner({});
            	self.banners.push(banner);
            	banner.edit();
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koBanner'));
    </script>
@endsection