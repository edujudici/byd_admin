
@extends('layouts.app')

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
    <div id="koPortfolio">
        <!-- ko with: portfolio -->
        <div data-bind="visible: $root.portfolio" style="display: none">
            <h1>New / Edit Portfolio</h1>
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
        					<label for="txtTitle">Title</label>
        					<input class="form-control" id="txtTitle" type="text" placeholder="Enter title" data-bind="value: title">
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
        
        <div data-bind="visible: !portfolio()" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-bind="click: addPortfolio">New Portfolio</a>
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
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: portfolioList">
                            <tr>
                                <td class="center">
                                    <i class="fa fa-pencil-square-o cursor-pointer" aria-hidden="true" data-bind="click: edit"></i>
                                    <i class="fa fa-trash-o cursor-pointer" aria-hidden="true" data-bind="click: remove"></i>
                                </td>
                                <td><span data-bind="text: title"></span></td>
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
            urlPortfolioSave = "{{ route('portfolio.save') }}",
            urlPortfolioDelete = "{{ route('portfolio.delete') }}";

        function Portfolio(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.POR_ID;
            self.image = ko.observable();
            self.file  = ko.observable().extend({
                required: {
                    message: "The file field is required",
                    onlyIf: function() {
                        return !self.id;
                    }
                }
            });
            self.title = ko.observable(obj.POR_TITLE).extend({
                required: {
                    params: true,
                    message: 'The title field is required'
                }
            });
            self.description = ko.observable(obj.POR_DESCRIPTION).extend({
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
            self.loadImage(obj.POR_IMAGE_ID);          

            self.edit = function()
            {
            	viewModel.portfolio(self);
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
                                viewModel.portfolioList.remove(item);
                                infoAlert.success(response.message);
                            }
                        };
                        Api.post(urlPortfolioDelete, data, callback);
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
                        self.id = response.data.POR_ID;
                        self.origin = response.data;
                        viewModel.portfolio(null);
                        infoAlert.success();
                    }
                };
                Api.postImage(urlPortfolioSave, formData, callback);
            }

            self.goBackData = function(item)
            {
                var dataOld = new Portfolio(self.origin),
                    position = viewModel.portfolioList.indexOf(item);
                viewModel.portfolioList.splice(position,1,dataOld);
            }

            self.cancel = function(item)
            {
                if (!item.id)
                    viewModel.portfolioList.remove(item);
                else
                    self.goBackData(item);
                viewModel.portfolio(null);                
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

            self.portfolioList = ko.observableArray();
            self.portfolio = ko.observable();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.portfolioList(ko.utils.arrayMap(response.data, function(obj) {
                        return new Portfolio(obj);
                    }));
                }
            };

            self.addPortfolio = function()
            {
            	var portfolio = new Portfolio({});
            	self.portfolioList.push(portfolio);
            	portfolio.edit();
            }
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koPortfolio'));
    </script>
@endsection