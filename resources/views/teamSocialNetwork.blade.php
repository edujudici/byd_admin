@extends('layouts.default')

@section('title', 'Team Social Network')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Team Social Network</li>
	</ol>
@endsection

@section('content')
    <div id="koTeamSocialNetwork">
        <!-- ko with: socialNetwork -->
        <div data-bind="visible: $root.socialNetwork" style="display: none">
            <h1>New / Edit Social Network</h1>
            <form>
        		<div class="form-group">
        			<div class="form-row">
        				<div class="col-md-6">
        					<label for="txtTeam">Team</label>
        					{{-- <input class="form-control" id="txtTeam" type="text" placeholder="Enter team" data-bind="value: teamId"> --}}
                            <select class="form-control" data-bind="
                                options: $root.team,
                                optionsText: 'description',
                                optionsValue: 'id',
                                optionsCaption: 'Selecione...',
                                value: teamId
                                ">
                            </select>
        				</div>
        				<div class="col-md-6">
        					<label for="txtIcon">Icon</label>
        					<input class="form-control" id="txtIcon" type="text" placeholder="Enter icon" data-bind="value: icon">
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
        
        <div data-bind="visible: !socialNetwork()" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addSocialNetwork">New Social Network</a>
                </div>
            </div>

            <div class="row" style="margin-top: 15px">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%" style="min-width: 50px"></th>
                                <th width="30%">Team</th>
                                <th width="30">Icon</th>
                                <th width="30">Link</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: teamSocialNetwork">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: $root.getName(teamId())"></span></td>
                                <td><span data-bind="text: icon"></span></td>
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
            urlTeamSocialNetworkSave = "{{ route('team.social.network.save') }}",
            urlTeamSocialNetworkDelete = "{{ route('team.social.network.delete') }}";

        function SocialNetwork(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.TSN_ID;
            self.teamId = ko.observable(obj.TEA_ID).extend({
                required: {
                    params: true,
                    message: 'The team field is required'
                }
            });

            self.icon = ko.observable(obj.TSN_ICON).extend({
                required: {
                    params: true,
                    message: 'The icon field is required'
                }
            });
            self.link = ko.observable(obj.TSN_LINK).extend({
                required: {
                    params: true,
                    message: 'The link field is required'
                }
            });

            self.errors = ko.validation.group(self);            

            self.edit = function()
            {
            	viewModel.socialNetwork(self);
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
                                viewModel.teamSocialNetwork.remove(item);
                                infoAlert.success(response.message);
                            }
                        };
                        Api.post(urlTeamSocialNetworkDelete, data, callback);
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

                    formData.append('teamId', self.teamId());
                    formData.append('icon', self.icon());
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
                        self.id = response.data.TSN_ID;
                        self.origin = response.data;
                        viewModel.socialNetwork(null);
                        infoAlert.success();
                    }
                };
                Api.postImage(urlTeamSocialNetworkSave, formData, callback);
            }

            self.goBackData = function(item)
            {
                var dataOld = new SocialNetwork(self.origin),
                    position = viewModel.teamSocialNetwork.indexOf(item);
                viewModel.teamSocialNetwork.splice(position,1,dataOld);
            }

            self.cancel = function(item)
            {
                if (!item.id)
                    viewModel.teamSocialNetwork.remove(item);
                else
                    self.goBackData(item);
                viewModel.socialNetwork(null);                
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
        }

        function ViewModel()
        {
            var self = this;

            self.teamSocialNetwork = ko.observableArray();
            self.socialNetwork = ko.observable();
            self.team = ko.observableArray();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.teamSocialNetwork(ko.utils.arrayMap(response.data.socialNetworks, function(obj) {
                        return new SocialNetwork(obj);
                    }));

                    self.team(response.data.team);
                }
            };

            self.addSocialNetwork = function()
            {
            	var socialNetwork = new SocialNetwork({});
            	self.teamSocialNetwork.push(socialNetwork);
            	socialNetwork.edit();
            }

            self.getName = function(id)
            {
                var obj = ko.utils.arrayFirst(self.team(), function(item)
                {
                    return id == item.id;
                });
                return obj ? obj.description : null;
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koTeamSocialNetwork'));
    </script>
@endsection