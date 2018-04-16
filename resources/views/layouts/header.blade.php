<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
	<a class="navbar-brand" href="index.html">Start Bootstrap</a>
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
				<a class="nav-link" href="{{ route('home.show') }}">
					<i class="fa fa-fw fa-dashboard"></i>
					<span class="nav-link-text">Dashboard</span>
				</a>
			</li>


			<li class="nav-item dropdown data-toggle="tooltip" data-placement="right" title="Home"">
		        <a class="nav-link dropdown-toggle" href="#" id="dropHome" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		        	<i class="fa fa-fw fa-home"></i>
					<span class="nav-link-text">Home</span>
		        </a>
		        <ul class="dropdown-menu" aria-labelledby="dropHome">
		        	<li><a class="dropdown-item" href="{{ route('banner.show') }}">Banner</a></li>
		          	<li><a class="dropdown-item" href="{{ route('services.offer.show') }}">Services Offer</a></li>
		          	<li><a class="dropdown-item" href="{{ route('partners.show') }}">Partners</a></li>
		        </ul>
		    </li>

		    <li class="nav-item dropdown data-toggle="tooltip" data-placement="right" title="Team"">
		        <a class="nav-link dropdown-toggle" href="#" id="dropTeam" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		        	<i class="fa fa-fw fa-users"></i>
					<span class="nav-link-text">Team</span>
		        </a>
		        <ul class="dropdown-menu" aria-labelledby="dropTeam">
		        	<li><a class="dropdown-item" href="{{ route('team.show') }}">Data Team</a></li>
		        	<li><a class="dropdown-item" href="{{ route('team.social.network.show') }}">Social Network</a></li>
		        </ul>
		    </li>

		    <li class="nav-item dropdown data-toggle="tooltip" data-placement="right" title="Company"">
		        <a class="nav-link dropdown-toggle" href="#" id="dropCompany" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		        	<i class="fa fa-fw fa-building"></i>
					<span class="nav-link-text">Company</span>
		        </a>
		        <ul class="dropdown-menu" aria-labelledby="dropCompany">
		        	<li><a class="dropdown-item" href="{{ route('company.show') }}">Data Company</a></li>
		        	<li><a class="dropdown-item" href="{{ route('about.show') }}">About</a></li>
		        </ul>
		    </li>

		    <li class="nav-item dropdown data-toggle="tooltip" data-placement="right" title="Gallery"">
		        <a class="nav-link dropdown-toggle" href="#" id="dropGallery" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		        	<i class="fa fa-fw fa-picture-o"></i>
					<span class="nav-link-text">Portfolio</span>
		        </a>
		        <ul class="dropdown-menu" aria-labelledby="dropGallery">
		        	<li><a class="dropdown-item" href="{{ route('portfolio.type.show') }}">Folders</a></li>
		        	<li><a class="dropdown-item" href="{{ route('portfolio.show') }}">Images</a></li>
		        </ul>
		    </li>
			
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Video">
				<a class="nav-link" href="{{ route('video.show') }}">
					<i class="fa fa-fw fa-video-camera"></i>
					<span class="nav-link-text">Video</span>
				</a>
			</li>

			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Services">
				<a class="nav-link" href="{{ route('services.show') }}">
					<i class="fa fa-fw fa-server"></i>
					<span class="nav-link-text">Services</span>
				</a>
			</li>

			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Contact">
				<a class="nav-link" href="{{ route('contact.show') }}">
					<i class="fa fa-fw fa-envelope-open"></i>
					<span class="nav-link-text">Contact</span>
				</a>
			</li>
		</ul>
		<ul class="navbar-nav sidenav-toggler">
			<li class="nav-item">
				<a class="nav-link text-center" id="sidenavToggler">
					<i class="fa fa-fw fa-angle-left"></i>
				</a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-fw fa-envelope"></i>
					<span class="d-lg-none">Messages
						<span class="badge badge-pill badge-primary">12 New</span>
					</span>
					<span class="indicator text-primary d-none d-lg-block">
						<i class="fa fa-fw fa-circle"></i>
					</span>
				</a>
				<div class="dropdown-menu" aria-labelledby="messagesDropdown">
					<h6 class="dropdown-header">New Messages:</h6>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">
						<strong>David Miller</strong>
						<span class="small float-right text-muted">11:21 AM</span>
						<div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">
						<strong>Jane Smith</strong>
						<span class="small float-right text-muted">11:21 AM</span>
						<div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">
						<strong>John Doe</strong>
						<span class="small float-right text-muted">11:21 AM</span>
						<div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item small" href="#">View all messages</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-fw fa-bell"></i>
					<span class="d-lg-none">Alerts
						<span class="badge badge-pill badge-warning">6 New</span>
					</span>
					<span class="indicator text-warning d-none d-lg-block">
						<i class="fa fa-fw fa-circle"></i>
					</span>
				</a>
				<div class="dropdown-menu" aria-labelledby="alertsDropdown">
					<h6 class="dropdown-header">New Alerts:</h6>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">
						<span class="text-success">
							<strong>
								<i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
						</span>
						<span class="small float-right text-muted">11:21 AM</span>
						<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">
						<span class="text-danger">
							<strong>
								<i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
						</span>
						<span class="small float-right text-muted">11:21 AM</span>
						<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">
						<span class="text-success">
							<strong>
								<i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
						</span>
						<span class="small float-right text-muted">11:21 AM</span>
						<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item small" href="#">View all alerts</a>
				</div>
			</li>
			<li class="nav-item">
				<form class="form-inline my-2 my-lg-0 mr-lg-2">
					<div class="input-group">
						<input class="form-control" type="text" placeholder="Search for...">
						<span class="input-group-append">
							<button class="btn btn-primary" type="button">
								<i class="fa fa-search"></i>
							</button>
						</span>
					</div>
				</form>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="modal" data-target="#exampleModal">
					<i class="fa fa-fw fa-sign-out"></i>Logout</a>
			</li>
		</ul>
	</div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<!-- Logout Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a class="btn btn-primary"
					href="{{ route('logout') }}"
					onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
			</div>
		</div>
	</div>
</div>