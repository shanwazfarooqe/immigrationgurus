<div class="panel panel-default">
	
	<div class="panel-body">
		<div role="tabpanel" style="background-color:#FFFFFF">
			<!-- Nav tabs-->

			<ul role="tablist" class="nav nav-tabs nav-tabs_custome">
				<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">
					<i class="icon-note"></i> &nbsp;&nbsp;New note </a>
				</li>
				<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
					<em class="fa fa-plus"></em> &nbsp;&nbsp;Log activity</a>
				</li>
				<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">
					<em class="icon-share-alt"></em> &nbsp;&nbsp;Create task</a>
				</li>

				<li role="presentation" id="email_temp"><a href="#email" aria-controls="email" role="tab" data-toggle="tab">
					<em class="fa fa-envelope-o"></em> &nbsp;&nbsp;Email

				</a>
			</li>

		</ul>

		<!-- Tab panes-->

		<div class="tab-content" style="background-color:#FFFFFF">
			<div id="home" role="tabpanel" class="tab-pane active">
				<form class="form-horizontal" action="{{ route('notes.store') }}" method="post">
				@csrf
					<input type="hidden" name="lead_id" value="{{ $lead->id }}">
					<input type="hidden" name="user_id" value="{{ auth()->id() }}">
					<textarea class="form-control" rows="8"  placeholder="Start typing to leave a note ......." style="border:none;margin-top:15px;" required="" name="content"></textarea>

					<hr>
					<button type="Submit" class="mb-sm btn btn-success btn-outline" style="margin:10px;">Save</button>
					<button type="reset" class="mb-sm btn btn-warning btn-outline" style="margin:10px;">Discard</button>
				</form>

			</div>
			<div id="profile" role="tabpanel" class="tab-pane">
				<form class="form-horizontal" action="{{ route('activities.store') }}" method="post">
				@csrf
					<input type="hidden" name="lead_id" value="{{ $lead->id }}">
					<input type="hidden" name="user_id" value="{{ auth()->id() }}">
					<div class="row" style="margin-top:15px;">
						<div class="btn-group col-md-2">
							<select class="form-control" name="log_a_call">
							   <option>Log a call
							   </option>
							   <option>Log an email
							   </option>
							   <option>Log a meeting
							   </option>
							</select>
						</div>

						<div class="btn-group col-md-2">
							<select class="form-control" name="out_come">
							   <option>No answer
							   </option>
							   <option>Busy
							   </option>
							   <option>Wrong number
							   </option>
							    <option>Left live message
							   </option>
							    <option>Left voice call
							   </option>
							    <option>Connected
							   </option>
							</select>
						</div>
						<div class="col-md-4 pull-right">
							<div id="" class="input-group date datetimepicker1">
								<input type="text" class="form-control" style="border:none; background-color:#FFFFFF" name="datetime" value="{{ date('d/m/Y H:i:s') }}">
								<span class="input-group-addon" style="border:none; background-color:#FFFFFF">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>
					<textarea class="form-control" rows="8"  placeholder="Describe the call ......." style="border:none;margin-top:15px;" name="content"></textarea>
					<hr>
					<button type="Submit" class="mb-sm btn btn-success btn-outline" style="margin:10px;">Save</button>
					<button type="reset" class="mb-sm btn btn-warning btn-outline" style="margin:10px;">Discard</button>
				</form>
			</div>
			<div id="messages" role="tabpanel" class="tab-pane">
				<form class="form-horizontal" action="{{ route('tasks.store') }}" method="post">
				@csrf
					<input type="hidden" name="lead_id" value="{{ $lead->id }}">
					<input type="hidden" name="user_id" value="{{ auth()->id() }}">
					<div class="row" style="margin-top:15px;">
						<div class="col-md-8">
							<input type="text" placeholder="Enter your task ..." style="border:none;" class="form-control" name="subject" required="">
						</div>
						<div class="col-md-4 pull-right">
							<div id="" class="input-group date datetimepicker1">
								<input type="text" class="form-control" value="{{ date('d/m/Y H:i:s') }}" style="border:none; background-color:#FFFFFF" name="datetime">
								<span class="input-group-addon" style="border:none; background-color:#FFFFFF">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>
					<hr>
					<textarea class="form-control" rows="8"  placeholder="Notes ..." style="border:none;margin-top:15px;" name="content" required=""></textarea>

					<hr>
					<button type="Submit" class="mb-sm btn btn-success btn-outline" style="margin:10px;">Save</button>
					<button type="reset" class="mb-sm btn btn-warning btn-outline" style="margin:10px;">Discard</button>
				</form>
			</div>

			<div id="email" role="tabpanel" class="tab-pane">
				<div class="row">
					<div class="tab_msg col-sm-3">



						<ul class="side-list" style="-webkit-padding-start: 20px;">
							<li> <a href="javascript:void(0)" class="btn btnc btn-primary" data-toggle="modal" data-target="#email_modal_add" >
								New email  <i class="fa fa-envelope-o"></i></a></li>

								<li><i class="fa fa-angle-right"></i> <a href="javascript:void(0)"  onclick="mail(event, 'id1')" id="defaultOpen" class="tablinks">Skilled visa</a></li>

								<li><i class="fa fa-angle-right"></i> <a href="javascript:void(0)"  onclick="mail(event, 'id2')" id="defaultOpen" class="tablinks">Business visa</a></li>

								<li><i class="fa fa-angle-right"></i> <a href="javascript:void(0)"  onclick="mail(event, 'id3')" id="defaultOpen" class="tablinks">General enquiries</a></li>

							</ul>

						</div>

						<!-- msg row 1 -->
						<div id="id1" class="tabcontent_msg col-sm-9">


							<table class="table table-hover mb-mails">
								<thead>
									<tr>
										<th colspan="3"> TEMPLATE NAME</th>
										<th class="text-center" style="min-width: 110px">MODIFIED BY</th>
									</tr>
								</thead>
								<tbody>
									<!-- ngRepeat: mail in mails | filter:folder-->
									<tr>
										<td>
											<div class="checkbox c-checkbox">
												<label>
													<input type="checkbox" checked="">
													<span class="fa fa-check"></span>
												</label>
											</div>
										</td>

										<td class="text-center checkbox-star attachment_icon attachment_icon">
											<input type="checkbox" id="starhalf" name="rating" checked=""><label class="half" for="starhalf">
												<em class="fa fa-star"></em>
											</label>


										</td>
										<td>
											<div class="mb-mail-meta profile-pic">
												<div class="pull-left">
													<div class="mb-mail-subject"  data-toggle="modal" data-target="#email_modal" >Request for more information</div>
												</div>
												<div class="mb-mail-preview">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>

											</div>
										</td>
										<td class="text-center">
											<div class="mb-mail-from"> David Thalhofer</div>
											<small>08 Oct 2017</small>
										</td>

									</tr>
									<!-- end ngRepeat: mail in mails | filter:folder-->


									<!-- ngRepeat: mail in mails | filter:folder-->
									<tr>
										<td>
											<div class="checkbox c-checkbox">
												<label>
													<input type="checkbox">
													<span class="fa fa-check"></span>
												</label>
											</div>
										</td>

										<td class="text-center checkbox-star attachment_icon attachment_icon">
											<input type="checkbox" id="starhalf2" name="rating"><label class="half" for="starhalf2">
												<em class="fa fa-star"></em>
											</label>


										</td>
										<td>
											<div class="mb-mail-meta profile-pic">
												<div class="pull-left">
													<div class="mb-mail-subject"  data-toggle="modal" data-target="#email_modal" >Lorem Ipsum</div>
												</div>
												<div class="mb-mail-preview">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>

											</div>
										</td>
										<td class="text-center">
											<div class="mb-mail-from"> David Thalhofer</div>
											<small>08 Oct 2017</small>
										</td>

									</tr>


								</tbody>
							</table>

						</div>
						<!-- msg row end -->

						<div id="id2" class="tabcontent_msg col-sm-9">
							<table class="table table-hover mb-mails">
								<thead>
									<tr>
										<th colspan="3"> TEMPLATE NAME</th>
										<th class="text-center" style="min-width: 110px">MODIFIED BY</th>

									</tr>
								</thead>
								<tbody>
									<!-- ngRepeat: mail in mails | filter:folder-->
									<tr>
										<td>
											<div class="checkbox c-checkbox">
												<label>
													<input type="checkbox" checked="">
													<span class="fa fa-check"></span>
												</label>
											</div>
										</td>

										<td class="text-center checkbox-star attachment_icon attachment_icon">
											<input type="checkbox" id="starhalf" name="rating" checked=""><label class="half" for="starhalf">
												<em class="fa fa-star"></em>
											</label>


										</td>
										<td>
											<div class="mb-mail-meta profile-pic">
												<div class="pull-left">
													<div class="mb-mail-subject"  data-toggle="modal" data-target="#email_modal" >Request for more information</div>
												</div>
												<div class="mb-mail-preview">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>

											</div>
										</td>
										<td class="text-center">
											<div class="mb-mail-from"> David Thalhofer</div>
											<small>08 Oct 2017</small>
										</td>

									</tr>
									<!-- end ngRepeat: mail in mails | filter:folder-->


									<!-- ngRepeat: mail in mails | filter:folder-->
									<tr>
										<td>
											<div class="checkbox c-checkbox">
												<label>
													<input type="checkbox">
													<span class="fa fa-check"></span>
												</label>
											</div>
										</td>

										<td class="text-center checkbox-star attachment_icon attachment_icon">
											<input type="checkbox" id="starhalf2" name="rating" checked=""><label class="half" for="starhalf2">
												<em class="fa fa-star"></em>
											</label>


										</td>
										<td>
											<div class="mb-mail-meta profile-pic">
												<div class="pull-left">
													<div class="mb-mail-subject"  data-toggle="modal" data-target="#email_modal" >Lorem Ipsum</div>
												</div>
												<div class="mb-mail-preview">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>

											</div>
										</td>
										<td class="text-center">
											<div class="mb-mail-from"> David Thalhofer</div>
											<small>08 Oct 2017</small>
										</td>

									</tr>


								</tbody>
							</table>
						</div>

						<div id="id3" class="tabcontent_msg col-sm-9">
							<table class="table table-hover mb-mails">
								<thead>
									<tr>
										<th colspan="3"> TEMPLATE NAME</th>
										<th class="text-center" style="min-width: 110px">MODIFIED BY</th>

									</tr>
								</thead>
								<tbody>
									<!-- ngRepeat: mail in mails | filter:folder-->
									<tr>
										<td>
											<div class="checkbox c-checkbox">
												<label>
													<input type="checkbox" >
													<span class="fa fa-check"></span>
												</label>
											</div>
										</td>

										<td class="text-center checkbox-star attachment_icon attachment_icon">
											<input type="checkbox" id="starhalf" name="rating" ><label class="half" for="starhalf">
												<em class="fa fa-star"></em>
											</label>


										</td>
										<td>
											<div class="mb-mail-meta profile-pic">
												<div class="pull-left">
													<div class="mb-mail-subject"  data-toggle="modal" data-target="#email_modal" >Request for more information</div>
												</div>
												<div class="mb-mail-preview">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>

											</div>
										</td>
										<td class="text-center">
											<div class="mb-mail-from"> David Thalhofer</div>
											<small>08 Oct 2017</small>
										</td>

									</tr>
									<!-- end ngRepeat: mail in mails | filter:folder-->


									<!-- ngRepeat: mail in mails | filter:folder-->
									<tr>
										<td>
											<div class="checkbox c-checkbox">
												<label>
													<input type="checkbox" checked="">
													<span class="fa fa-check"></span>
												</label>
											</div>
										</td>

										<td class="text-center checkbox-star attachment_icon attachment_icon">
											<input type="checkbox" id="starhalf2" name="rating"><label class="half" for="starhalf2">
												<em class="fa fa-star"></em>
											</label>


										</td>
										<td>
											<div class="mb-mail-meta profile-pic">
												<div class="pull-left">
													<div class="mb-mail-subject"  data-toggle="modal" data-target="#email_modal" >Lorem Ipsum</div>
												</div>
												<div class="mb-mail-preview">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>

											</div>
										</td>
										<td class="text-center">
											<div class="mb-mail-from"> David Thalhofer</div>
											<small>08 Oct 2017</small>
										</td>

									</tr>


								</tbody>
							</table>
						</div>

					</div>
				</div>


			</div>

		</div>
	</div>

</div>