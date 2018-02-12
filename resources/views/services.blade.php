@extends('layouts.app')

@section('title', 'Services')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Services</li>
	</ol>
@endsection

@section('content')
    <div id="koServices">
        <!-- ko with: service -->
        <div data-bind="visible: $root.service" style="display: none">
            <h1>New / Edit Service</h1>
            <form>
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
        			<div class="form-row">
	        			<label for="txtIcon">Icon</label>
	        			<input class="form-control" id="txtIcon" type="text" placeholder="Enter icon" data-bind="value: icon">
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
        
        <div data-bind="visible: !service()" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addService">New Service</a>
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
                                <th width="30">Icon</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: services">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: title"></span></td>
                                <td><span data-bind="text: description"></span></td>
                                <td><span data-bind="text: icon"></span></td>
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
            urlServiceSave = "{{ route('service.save') }}",
            urlServiceDelete = "{{ route('service.delete') }}";

        function Service(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.SER_ID;
            self.title = ko.observable(obj.SER_TITLE).extend({
                required: {
                    params: true,
                    message: 'The title field is required'
                }
            });
            self.description = ko.observable(obj.SER_DESCRIPTION).extend({
                required: {
                    params: true,
                    message: 'The description field is required'
                }
            });
            self.icon  = ko.observable(obj.SER_ICON).extend({
                required: {
                    params: true,
                    message: 'The icon field is required'
                }
            });

            self.errors = ko.validation.group(self);

            self.edit = function()
            {
            	viewModel.service(self);
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
                                viewModel.services.remove(item);
                                infoAlert.success(response.message);
                            }
                        };
                        Api.post(urlServiceDelete, data, callback);
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

                    formData.append('title', self.title());
                    formData.append('description', self.description());
                    formData.append('icon', self.icon());

                var callback = function(response)
                {
                    if(!response.status)
                    {
                        infoAlert.error([response.message]);
                        return;
                    }
                    else
                    {
                        self.id = response.data.SER_ID;
                        self.origin = response.data;
                        viewModel.service(null);
                        infoAlert.success();
                    }
                };
                Api.postImage(urlServiceSave, formData, callback);
            }

            self.goBackData = function(item)
            {
                var dataOld = new Service(self.origin),
                    position = viewModel.services.indexOf(item);
                viewModel.services.splice(position,1,dataOld);
            }

            self.cancel = function(item)
            {
                if (!item.id)
                    viewModel.services.remove(item);
                else
                    self.goBackData(item);
                viewModel.service(null);                
            }
        }

        function ViewModel()
        {
            var self = this;

            self.services = ko.observableArray();
            self.service = ko.observable();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.services(ko.utils.arrayMap(response.data, function(obj) {
                        return new Service(obj);
                    }));
                }
            };

            self.addService = function()
            {
            	var service = new Service({});
            	self.services.push(service);
            	service.edit();
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koServices'));
    </script>
@endsection