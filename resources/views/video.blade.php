@extends('layouts.default')

@section('title', 'Porfolio')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Video</li>
	</ol>
@endsection

@section('content')
    <div id="koVideo">
        <!-- ko with: video -->
        <div data-bind="visible: $root.video" style="display: none">
            <h1>New / Edit Video</h1>
            <form>
        		<div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="txtTitle">Title</label>
                            <input class="form-control" id="txtTitle" type="text" placeholder="Enter title" data-bind="value: title">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="txtDescription">Description</label>
                            <input class="form-control" id="txtDescription" type="text" placeholder="Enter description" data-bind="value: description">
                        </div>
                    </div>
                </div>

                <div class="form-group">
        			<div class="form-row">
        				<div class="col-md-6">
        					<label for="txtUrl">Url</label>
        					<input class="form-control" id="txtUrl" type="text" placeholder="Enter url" data-bind="value: url">
        				</div>
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
        
        <div data-bind="visible: !video()" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addVideo">New Video</a>
                </div>
            </div>

            <div class="row" style="margin-top: 15px">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%" style="min-width: 50px"></th>
                                <th width="30%">Title</th>
                                <th width="30%">Description</th>
                                <th width="30%">Url</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: videoList">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: title"></span></td>
                                <td><span data-bind="text: description"></span></td>
                                <td><span data-bind="text: url"></span></td>
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
            urlVideoSave = "{{ route('video.save') }}",
            urlVideoDelete = "{{ route('video.delete') }}";

        function Video(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.VID_ID;
            self.title = ko.observable(obj.VID_TITLE).extend({
                required: {
                    params: true,
                    message: 'The title field is required'
                },
                maxLength: {
                    params: 50,
                    message: 'The title may not be greater than 50 characters.'
                }
            });
            self.description = ko.observable(obj.VID_DESCRIPTION).extend({
                required: {
                    params: true,
                    message: 'The description field is required'
                }
            });
            self.url = ko.observable(obj.VID_URL).extend({
                required: {
                    params: true,
                    message: 'The url field is required'
                }
            });

            self.errors = ko.validation.group(self);

            self.edit = function()
            {
            	viewModel.video(self);
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
                                viewModel.videoList.remove(item);
                                infoAlert.success(response.message);
                            }
                        };
                        Api.post(urlVideoDelete, data, callback);
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
                    
                    formData.append('url', self.url());
                    formData.append('title', self.title());
                    formData.append('description', self.description());

                var callback = function(response)
                {
                    if(!response.status)
                    {
                        infoAlert.error([response.message]);
                        return;
                    }
                    else
                    {
                        self.id = response.data.VID_ID;
                        self.origin = response.data;
                        viewModel.video(null);
                        infoAlert.success();
                    }
                };
                Api.postImage(urlVideoSave, formData, callback);
            }

            self.goBackData = function(item)
            {
                var dataOld = new Video(self.origin),
                    position = viewModel.videoList.indexOf(item);
                viewModel.videoList.splice(position,1,dataOld);
            }

            self.cancel = function(item)
            {
                if (!item.id)
                    viewModel.videoList.remove(item);
                else
                    self.goBackData(item);
                viewModel.video(null);                
            }
        }

        function ViewModel()
        {
            var self = this;

            self.videoList = ko.observableArray();
            self.video = ko.observable();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.videoList(ko.utils.arrayMap(response.data, function(obj) {
                        return new Video(obj);
                    }));
                }
            };

            self.addVideo = function()
            {
            	var video = new Video({});
            	self.videoList.push(video);
            	video.edit();
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koVideo'));
    </script>
@endsection