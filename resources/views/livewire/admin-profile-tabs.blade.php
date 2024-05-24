<div>

<div class="profile-tab height-100-p">
									<div class="tab height-100-p">
										<ul class="nav nav-tabs customtab" role="tablist">
											<li class="nav-item">
												<a wire:click.prevent='selectTab("personal_details")' class="nav-link {{ $tab == 'personal_details' ? 'active' : '' }}" data-toggle="tab" href="#personal_details" role="tab">Personal Details</a>
											</li>
											<li class="nav-item">
												<a wire:click.prevent='selectTab("update_password")' class="nav-link {{ $tab == 'update_password' ? 'active' : '' }}"  data-toggle="tab" href="#update_password" role="tab">Update Password</a>
											</li>
											
										</ul>
										<div class="tab-content">
											<!-- Timeline Tab start -->
											<div class="tab-pane fade {{ $tab == 'personal_details' ? 'active show' : '' }}" id="personal_details" role="tabpanel">
												<div class="pd-20">
													<form wire:submit.prevent='updateAdminPersonalDetails()'>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" wire:model='name' placeholder="Enter full name">
                                                                    @error('name')
                                                                    <span class = "text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="text" class="form-control" wire:model='email' placeholder="Enter email">
                                                                    @error('email')
                                                                    <span class = "text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Username</label>
                                                                    <input type="text" class="form-control" wire:model='type' placeholder="Enter username">
                                                                    @error('type')
                                                                    <span class = "text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                        
                                                    </form>
												</div>
											</div>
											<!-- Timeline Tab End -->
											<!-- Tasks Tab start -->
											<div class="tab-pane fade {{ $tab == 'update_password' ? 'active show' : '' }}" id="update_password" role="tabpanel">
												<div class="pd-20 profile-task-wrap">
													------ Update Password here ----
												</div>
											</div>
											<!-- Tasks Tab End -->
											
										</div>
									</div>
								</div>
</div>
