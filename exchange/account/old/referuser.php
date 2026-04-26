<?php include('header.php'); ?>

            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Referrals</h5>
            </div>
        </div>
    </div>
    <div>
    </div>	<div>
    </div>    <div class="row">
        <div class="col-md-12">
            <div class="row mb-3 mb-md-4">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <div class="p-3 mb-1 card shadow-none h-100" >
                        <div class="row h-100 align-items-center">
                             <div class="col-12 col-md-7">
                                <div class="mb-3">
                                    <!--<h6 class="mb-4 text-white font-weight-400">Welcome, James Fred!</h6>-->
                                    <small class="text-muted mb-3 text-uppercase" style="font-size:0.7rem !important">Referral Bonus</small>
                                    <h1 class="mb-2 text-white" style="font-size:2rem !important"><b>$<?php echo number_format($user['ref_bonus'], 2, '.', ','); ?></b></h1>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 mt-3 mt-md-0">
                                <div class="row align-items-center h-100">
                                    <div class="col">
                                        <a href="withdrawals" class="btn py-2 px-4 w-100 text-white" style="font-size:0.8rem; background: hsla(0,0%,100%,.2); border:1px solid hsla(0,0%,100%,.1); border-radius:0.5rem">Withdraw Funds</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card shadow-none h-100">
                        <div class="card-body pb-1">
                            <h5 class="text-black">Invite friends to earn</h5>
                            <p>Earn more commissions by inviting your friends to join us.</p>
                            <div class="input-group">
                                <input type="text" class="form-control myInput readonly"
                                    value="https://sterlinguniongroup.com/signup.htm?ref=<?php echo $user['email']; ?>" id="reflink" readonly style="border: 1px solid rgba(255,255,255,0.2);">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" onclick="myFunction()" type="button" style="padding:5px 12px; color: rgba(255,255,255,0.2);background: #2D2D2D;border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-none">
                <div class="card-header">
                    <h6 class="mb-0 title1 text-center text-md-left">Your Referrals.</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!--<div class="col-12">-->
                            <!--<strong>Referral link:</strong><br>-->
                            <!--<div class="mb-3 input-group">-->
                            <!--    <input type="text" class="form-control myInput readonly"-->
                            <!--        value="https://teslasafetrade.com/register?ref=greyy" id="reflink" readonly style="border: 1px solid #9212E7;">-->
                            <!--    <div class="input-group-append">-->
                            <!--        <button class="btn btn-outline-primary" onclick="myFunction()" type="button" style="color: #9212E7;background: #2D2946;border: 1px solid #9212E7;">-->
                            <!--            <i class="fas fa-copy"></i>-->
                            <!--        </button>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<strong>Referral ID</strong><br>-->
                            <!--<h6 class="text-white mb-2"> frose12</h6>-->
                            <!--<h6 class="title1">-->
                            <!--    <small>You were referred by</small><br>-->
                            <!--    <i class="fa fa-user"></i><br>-->
                            <!--    <small>null</small>-->
                            <!--</h6>-->
                        <!--</div>-->
                        <div class="col-12">
                            <div class="table-responsive">
								<table id="UserTable" class="UserTable table table-hover text- border">
									<thead>
										<tr>
											<th>Client name</th>
                                            <th>Ref. level</th>
                                            <th>Parent</th>
                                            <th>Client status</th>
                                            <th>Date registered</th>
										</tr>
									</thead>
									<tbody> 
                                        
                                    </tbody> 
								</table>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
            </div>
            <?php include('footer.php'); ?>