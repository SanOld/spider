<!--Edit user -->

		<div id="modal-100" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Bearbeiten eines Benutzer</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="alert alert-danger m-t-20">
	                    Bitte geben Sie die markierten Felder korrekt ein.
	                </div>
					<h3 class="subheading">Benutzerinformation</h3>
					<hr>
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-2 control-label">Status</label>
								<div class="col-lg-10">
									<div class="btn-group btn-toggle"> 
										<button class="btn btn-sm btn-default">AKTIV</button>
										<button class="btn btn-sm active">DEAKTIVIEREN</button>
									</div>
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2">Benutzerrollen</label>
	                            <div class="col-lg-10">
	                            	<span class="no-edit-text">Träger</span>
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
	                            </div>
							</div>
							  <div class="form-group">
								<label class="col-lg-2">Organisation</label>
	                            <div class="col-lg-10">
	                           	 	<span class="no-edit-text">Nachbarschafts- und Selbsthilfezentrum in der UFA-Fabrik e.V.</span>
	   								<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
	   									<i class="fa fa-question"></i>
	   								</button>
	                           </div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Finanzrecht</label>
								<div class="col-lg-10">
									<div class="btn-group btn-toggle"> 
										<button class="btn btn-sm btn-default">JA</button>
										<button class="btn btn-sm active">NEIN</button>
									</div>
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
								</div>
							</div>
							<div class="form-group">
	                            <label class="col-lg-2 control-label">Anrede</label>
	                            <div class="col-lg-10">
	                                <div class="radio-inline">
	                                    <label for="radio-edit" class="cr-styled">
	                                        <input type="radio" value="option1" name="radio-edit" id="radio-edit" checked=""> 
	                                        <i class="fa"></i>
	                                        Herr 
	                                    </label>
	                                </div>
	                                <div class="radio-inline">
	                                    <label for="radio-edit2" class="cr-styled">
	                                        <input type="radio" value="option2" name="radio-edit" id="radio-edit2"> 
	                                        <i class="fa"></i> 
	                                        Frau
	                                    </label>
	                                </div>
	                            </div>
	                        </div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="col-lg-4 control-label" for="username">Titel</label>
										<div class="col-lg-8">
											<div class="wrap-hint">
												<input class="form-control" type="text" id="username" value="">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-4 control-label" for="username">Funktion</label>
										<div class="col-lg-8">
											<div class="wrap-hint">
												<input class="form-control" type="text" id="username" value="">
											</div>
										</div>
									</div>
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" for="fname">Vorname</label>
										<div class="col-lg-8 wrap-line error"> 
											<input class="form-control" type="text" id="fname" value="">
											<label id="username-error" class="error" for="username">Bitte geben Sie Vornamen ein</label>
											<span class="glyphicon glyphicon-remove form-control-feedback"></span>
										</div>
									</div>
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" for="fname">Nachname</label>
										<div class="col-lg-8 wrap-line error"> 
											<input class="form-control" type="text" id="fname" value="">
											<label id="username-error" class="error" for="username">Bitte geben Sie Nachnamen ein</label>
											<span class="glyphicon glyphicon-remove form-control-feedback"></span>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="col-lg-3 control-label" for="username">Benutzername</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="username" value="jack.nik">
											</div>
										</div>
									</div>
									 <div class="form-group">
										<label class="col-lg-3 control-label" for="email">Email</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="email" value="jack.nik@mail.com">
											</div>
										</div>
										
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label" for="phone">Telefon</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="phone" value="(030) 2888 496">
											</div>
										</div>
										
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="form-custom-box clearfix">
									<div class="col-lg-12">
										<h4>Passwort ändern</h4>
									</div>
									<div class="col-lg-4">
										<label>Altes Passwort</label>
										<input class="form-control" type="text" id="phone" value="">
									</div>
									<div class="col-lg-4">
										<label>Neues Passwort</label>
										<input class="form-control" type="text" id="phone" value="">
									</div>
									<div class="col-lg-4">
										<label>Neues Passwort wiederholen</label>
										<input class="form-control" type="text" id="phone" value="">
									</div>
								</div>
							</div>
							<div class="form-group group-btn">
								<div class="col-lg-2">
									<a class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></a>
								</div>
								<div class="col-lg-6 text-right pull-right">
								 	<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
									<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

<!--End Edit user -->
<script>
	$('.sweet-4').on('click', function(){
		swal({
          title: "Sind Sie sicher?",
          text: "Diese Datei wird nicht wiedererstellt!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: 'Ja, löschen!',
          cancelButtonText: "Abbrechen",
          closeOnConfirm: false
        },
        function(){
          swal("Gelöscht!", "Ihre Datrei ist erfolgreich gelöscht!", "success");
        });
	 })
</script>