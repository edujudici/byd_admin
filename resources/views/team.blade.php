@extends('layouts.app')

@section('title', 'Team')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Team</li>
	</ol>
@endsection

@section('content')
    <div id="koTeam">
        <!-- ko with: person -->
        <div data-bind="visible: $root.person" style="display: none">
            <h1>New / Edit Person</h1>
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
        				<div class="col-md-6">
        					<label for="txtName">Name</label>
        					<input class="form-control" id="txtName" type="text" placeholder="Enter name" data-bind="value: name">
        				</div>
        				<div class="col-md-6">
        					<label for="txtDescription">Description</label>
        					<input class="form-control" id="txtDescription" type="text" placeholder="Enter description" data-bind="value: description">
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
        
        <div data-bind="visible: !person()" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addPerson">New Person</a>
                </div>
            </div>

            <div class="row" style="margin-top: 15px">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%" style="min-width: 50px"></th>
                                <th width="30%">Name</th>
                                <th width="30">Description</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: team">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: name"></span></td>
                                <td><span data-bind="text: description"></span></td>
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
            urlTeamSave = "{{ route('team.save') }}",
            urlTeamDelete = "{{ route('team.delete') }}";

        function Person(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.TEA_ID;
            self.image = ko.observable();
            self.file  = ko.observable().extend({
                required: {
                    message: "The file field is required",
                    onlyIf: function() {
                        return !self.id;
                    }
                }
            });
            self.name = ko.observable(obj.TEA_NAME).extend({
                required: {
                    params: true,
                    message: 'The name field is required'
                }
            });
            self.description = ko.observable(obj.TEA_DESCRIPTION).extend({
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
            self.loadImage(obj.TEA_IMAGE_ID);          

            self.edit = function()
            {
            	viewModel.person(self);
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
                                viewModel.team.remove(item);
                                infoAlert.success(response.message);
                            }
                        };
                        Api.post(urlTeamDelete, data, callback);
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

                    formData.append('name', self.name());
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
                        self.id = response.data.TEA_ID;
                        self.origin = response.data;
                        viewModel.person(null);
                        infoAlert.success();
                    }
                };
                Api.postImage(urlTeamSave, formData, callback);
            }

            self.goBackData = function(item)
            {
                var dataOld = new Person(self.origin),
                    position = viewModel.team.indexOf(item);
                viewModel.team.splice(position,1,dataOld);
            }

            self.cancel = function(item)
            {
                if (!item.id)
                    viewModel.team.remove(item);
                else
                    self.goBackData(item);
                viewModel.person(null);                
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

            self.team = ko.observableArray();
            self.person = ko.observable();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.team(ko.utils.arrayMap(response.data, function(obj) {
                        return new Person(obj);
                    }));
                }
            };

            self.addPerson = function()
            {
            	var person = new Person({});
            	self.team.push(person);
            	person.edit();
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koTeam'));
    </script>
@endsection