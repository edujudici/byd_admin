@extends('layouts.default')

@section('title', 'Porfolio')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Portfolio</li>
	</ol>
@endsection

@section('content')
    <div id="koPortfolioType">
        <!-- ko with: portfolioType -->
        <div data-bind="visible: $root.portfolioType" style="display: none">
            <h1>New / Edit Folder</h1>
            <form>
        		<div class="form-group">
        			<div class="form-row">
        				<div class="col-md-6">
        					<label for="txtTitle">Title</label>
        					<input class="form-control" id="txtTitle" type="text" placeholder="Enter title" data-bind="value: title">
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
        
        <div data-bind="visible: !portfolioType()" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addPortfolioType">New Folder</a>
                </div>
            </div>

            <div class="row" style="margin-top: 15px">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%" style="min-width: 50px"></th>
                                <th width="30%">Title</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: portfolioTypeList">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: title"></span></td>
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
            urlPortfolioTypeSave = "{{ route('portfolio.type.save') }}",
            urlPortfolioTypeDelete = "{{ route('portfolio.type.delete') }}";

        function PortfolioType(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.POT_ID;
            self.title = ko.observable(obj.POT_TITLE).extend({
                required: {
                    params: true,
                    message: 'The title field is required'
                }
            });

            self.errors = ko.validation.group(self);

            self.edit = function()
            {
            	viewModel.portfolioType(self);
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
                                viewModel.portfolioTypeList.remove(item);
                                infoAlert.success(response.message);
                            }
                        };
                        Api.post(urlPortfolioTypeDelete, data, callback);
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

                var callback = function(response)
                {
                    if(!response.status)
                    {
                        infoAlert.error([response.message]);
                        return;
                    }
                    else
                    {
                        self.id = response.data.POT_ID;
                        self.origin = response.data;
                        viewModel.portfolioType(null);
                        infoAlert.success();
                    }
                };
                Api.postImage(urlPortfolioTypeSave, formData, callback);
            }

            self.goBackData = function(item)
            {
                var dataOld = new PortfolioType(self.origin),
                    position = viewModel.portfolioTypeList.indexOf(item);
                viewModel.portfolioTypeList.splice(position,1,dataOld);
            }

            self.cancel = function(item)
            {
                if (!item.id)
                    viewModel.portfolioTypeList.remove(item);
                else
                    self.goBackData(item);
                viewModel.portfolioType(null);                
            }
        }

        function ViewModel()
        {
            var self = this;

            self.portfolioTypeList = ko.observableArray();
            self.portfolioType = ko.observable();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.portfolioTypeList(ko.utils.arrayMap(response.data, function(obj) {
                        return new PortfolioType(obj);
                    }));
                }
            };

            self.addPortfolioType = function()
            {
            	var portfolioType = new PortfolioType({});
            	self.portfolioTypeList.push(portfolioType);
            	portfolioType.edit();
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koPortfolioType'));
    </script>
@endsection