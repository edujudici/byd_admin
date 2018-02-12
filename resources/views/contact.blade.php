@extends('layouts.app')

@section('title', 'Contact')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Contact</li>
	</ol>
@endsection

@section('content')
    <div id="koContact">
        
        <div class="row" style="margin-top: 15px">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="10%">Name</th>
                            <th width="10%">Lastname</th>
                            <th width="10%">E-mail</th>
                            <th width="10%">Phone</th>
                            <th width="10%">Message</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: contacts">
                        <tr>
                            <td><span data-bind="text: name"></span></td>
                            <td><span data-bind="text: lastname"></span></td>
                            <td><span data-bind="text: email"></span></td>
                            <td><span data-bind="text: phone"></span></td>
                            <td><span data-bind="text: message"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

        var response =  {!! $response !!};

        function Contact(obj)
        {
            var self = this;

            self.origin = obj;

            self.id    = obj.CON_ID;
            self.name = obj.CON_NAME;
            self.lastname = obj.CON_LASTNAME;
            self.email = obj.CON_EMAIL;
            self.phone = obj.CON_PHONE;
            self.message = obj.CON_MESSAGE;
        }

        function ViewModel()
        {
            var self = this;

            self.contacts = ko.observableArray();

            self.setData = function(response)
            {
                if (response.status)
                {
                    self.contacts(ko.utils.arrayMap(response.data, function(obj) {
                        return new Contact(obj);
                    }));
                }
            };
        }        

        var viewModel = new ViewModel();
        viewModel.setData(response);
        ko.applyBindings(viewModel, document.getElementById('koContact'));
    </script>
@endsection