<?php 
	//define('SERVER_URL', 'http://time-tracking.itera-research.com');
	//define('SERVER_URL', 'http://stormhost');
define('SERVER_URL','http://'.$_SERVER['SERVER_NAME']);
?>

<!-- Le styles -->
<link href="/resttest/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/resttest/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="/resttest/debug.css" rel="stylesheet">


	<div class="hidden">

		<div class="httpfile">
			<a class="close">&times;</a>
			<div class="row show-grid">
				<div class="span2">
					<div class="control-group">
						<div class="controls">
							<input type="text" class="input-medium fakeinputname" value="">
						</div>
					</div>
				</div>

				<div class="span3">
					<div class="control-group">
						<div class="controls">
							<input class="input-file realinputvalue" multiple type="file">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="httpparameter">
			<a class="close">&times;</a>
			<div class="row show-grid">
				<div class="span2">
					<div class="control-group">
						<div class="controls">
							<input type="text" class="input-medium fakeinputname" value="">
						</div>
					</div>
				</div>

				<div class="span3">
					<div class="control-group">
						<div class="controls">
							<!-- <textarea class="input-xlarge realinputvalue" rows="2"></textarea>-->
							<input type="text" class="input-xlarge realinputvalue" value="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="container">

		<div class="row show-grid">
			<div id="leftcolumn" class="span6">
              <form id="login" class="well" target="outputframe">
                <fieldset>
                  <legend>Authorisation</legend>

                  <br />


                  <div class="row show-grid">
                    <div class="span4">
                      <div class="control-group">
                        <label class="control-label" for="urlvalue">Endpoint</label>
                        <div class="controls">
                          <input type="text" class="span4" id="UrlLogin"
                                 value="<?php echo SERVER_URL;?>/api/login">
                        </div>
                      </div>
                    </div>
                    <div class="span1">
                      <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                          <div class="btn btn-success login">Login</div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="row show-grid">
                    <div class="span6">
                      <div class="control-group">
                        <label class="control-label">Login params</label>
                        <div class="controls">
                          
                          <!--<input class="span2" type="text" placeholder="AccountUrl" id="AccountUrl_" value="test">--> 
                          <input class="span2" type="text" placeholder="Username" id="Username_" value="test">
                          <input class="span2" type="password" placeholder="Password" id="Password_" value="test">
                        </div>
                      </div>
                    </div>
                  </div>

                </fieldset>
              </form>
				<form id="paramform" class="well" target="outputframe">
					<fieldset>
						<legend>HTTP request options</legend>

						<br />


						<div class="row show-grid">
							<div class="span1">
								<div class="control-group">
									<label class="control-label" for="httpmethod">Method</label>
									<div class="controls">
										<select class="input-small" id="httpmethod">
											<option>GET</option>
											<option>POST</option>
											<option>PUT</option>
											<option>DELETE</option>
										</select>
									</div>
								</div>
							</div>

							<div class="span4">
								<div class="control-group">
									<label class="control-label" for="urlvalue">Endpoint</label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="urlvalue"
											value="<?php echo SERVER_URL;?>/api/user">
									</div>
								</div>
							</div>
						</div>
						<div class="row show-grid">
							<div class="span1">
								
							</div>

							<div class="span4">
								<div class="control-group">
									<label class="control-label" for="tokenvalue">Token</label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="tokenvalue"
											value="">
									</div>
								</div>
							</div>
						</div>

						<p class="help-block">Method and Endpoint are required. Click
							below to add additional parameters.</p>

						<div id="allparameters">

							<div class="row show-grid">
								<div class="span2">
									<div class="control-group">
										<label class="control-label">Parameter Name</label>
									</div>
								</div>

								<div class="span3">
									<div class="control-group">
										<label class="control-label">Parameter Value</label>
									</div>
								</div>
							</div>

						</div>

						<div align="left">
							<button id="addprambutton" class="btn btn-primary">
								<i class="icon-plus icon-white"></i> Add parameter
							</button>
							<button id="addfilebutton" class="btn btn-primary">
								<i class="icon-file icon-white"></i> Add file
							</button>
						</div>
						<br />

						<div align="right">
							<button id="submitajax" class="btn btn-success btn-large">
								<i class="icon-download-alt icon-white"></i> Ajax request
							</button>
							<img src="spinner.gif" id="ajaxspinner" />
						</div>
					</fieldset>
				</form>

				<div id="errordiv"></div>
        
  			<div class="alert alert-info">
					<a class="close" data-dismiss="alert">&times;</a> <strong>Welcome!</strong>
          Use this simple page to poke around at the API.
          Specify HTTP method, URL and parameters, and click on <b>Ajax Request</b>.
          Note that this page requires a browser with HTML5 support.
				</div>

			</div>

			<div class="span5">
				<div id="ajaxoutput">
					<pre id="statuspre">0</pre>
					<pre class="pre-scrollable prettyprint linenums" id="outputpre"></pre>
					<pre class="pre-scrollable prettyprint linenums" id="headerpre"></pre>
				</div>
			</div>
		</div>

		<br>


	</div>

	<script src="/resttest/jquery-1.10.2.min.js"></script>
	<script src="/resttest/bootstrap/js/bootstrap.min.js"></script>
	<script src="/resttest/debug.js"></script>
