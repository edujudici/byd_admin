@extends('layouts.default')

@section('title', 'About')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">About</li>
	</ol>
@endsection

@section('content')
    <div id="koAbout">
        <!-- ko with: about -->
        <div data-bind="visible: $root.about" style="display: none">
            <h1>New / Edit About</h1>
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
	        			<label for="txtType">Type</label>
	        			{{-- <input class="form-control" id="txtType" type="text" placeholder="Enter type" data-bind="value: type"> --}}
                        <select class="form-control" data-bind="
                            options: $root.aboutTypes,
                            optionsText: 'description',
                            optionsValue: 'id',
                            optionsCaption: 'Selecione...',
                            value: type
                            ">
                        </select>
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
        
        <div data-bind="visible: !about()" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addAbout">New About</a>
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
                                <th width="30">Type</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: aboutList">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: title"></span></td>
                                <td><span data-bind="text: description"></span></td>
                                <td><span data-bind="text: $root.getType(type())"></span></td>
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
            urlAboutSave = "{{ route('about.save') }}",
            urlAboutDelete = "{{ route('about.delete') }}";

        function About(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.ABO_ID;

            self.title = ko.observable(obj.ABO_TITLE).extend({
                required: {
                    params: true,
                    message: 'The title field is required'
                },
                maxLength: {
                    params: 50,
                    message: 'The title may not be greater than 50 characters.'
                }
            });
            self.description = ko.observable(obj.ABO_DESCRIPTION).extend({
                required: {
                    params: true,
                    message: 'The description field is required'
                },
                maxLength: {
                    params: 200,
                    message: 'The description may not be greater than 200 characters.'
                }
            });
            self.type  = ko.observable(obj.ABO_TYPE).extend({
                required: {
                    params: true,
                    message: 'The type field is required'
                }
            });

            self.errors = ko.validation.group(self);

            self.edit = function()
            {
            	viewModel.about(self);
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
                                viewModel.aboutList.remove(item);
                                infoAlert.success(response.message);
                            }
                        };
                        Api.post(urlAboutDelete, data, callback);
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
                    formData.append('type', self.type());

                var callback = function(response)
                {
                    if(!response.status)
                    {
                        infoAlert.error([response.message]);
                        return;
                    }
                    else
                    {
                        self.id = response.data.ABO_ID;
                        self.origin = response.data;
                        viewModel.about(null);
                        infoAlert.success();
                    }
                };
                Api.postImage(urlAboutSave, formData, callback);
            }

            self.goBackData = function(item)
            {
                var dataOld = new About(self.origin),
                    position = viewModel.aboutList.indexOf(item);
                viewModel.aboutList.splice(position,1,dataOld);
            }

            self.cancel = function(item)
            {
                if (!item.id)
                    viewModel.aboutList.remove(item);
                else
                    self.goBackData(item);
                viewModel.about(null);                
            }
        }

        function ViewModel()
        {
            var self = this;

            self.aboutList = ko.observableArray();
            self.about = ko.observable();
            self.aboutTypes = ko.observableArray();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.aboutList(ko.utils.arrayMap(response.data.aboutList, function(obj) {
                        return new About(obj);
                    }));

                    self.aboutTypes(response.data.aboutTypes);
                }
            };

            self.addAbout = function()
            {
            	var about = new About({});
            	self.aboutList.push(about);
            	about.edit();
            }

            self.getType = function(id)
            {
                var type = ko.utils.arrayFirst(self.aboutTypes(), function(obj)
                {
                    return id == obj.id;
                });
                return type ? type.description : null;
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koAbout'));
    </script>
@endsection