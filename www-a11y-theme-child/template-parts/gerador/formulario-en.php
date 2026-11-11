<?php
/**
 * Gerador da Declaração de Acessibilidade e Usabilidade: formulário (EN).
 * Markup vindo de amagovpt/a11y-da (gerador/en/index.html), sem o cabeçalho, o rodapé
 * e o breadcrumb, que passam a ser os do tema.
 */
defined( 'ABSPATH' ) || exit;
?>
		<section id="content-gerador">
			<div id="accstatement">
		
		
				<section class="page create gerador" hidden="hidden">
					<div class="container tab-container">
					
						<nav class="box box-simple box-full tab-menu" id="toc">
							<header id="toucheading" class="box-h box-h-full">
								<button type="button" onclick="menugerador()" id="menugerador" aria-expanded="true">
									See Contents of the Assessment
								</button>
							</header>

							<div class="box-i gerador" id="tab-menu" role="tablist">
								<ol>
									<li value="0" class="selected">
										<div role="tab" aria-selected="true" aria-controls="instrucoes-tab" aria-labelledby="instrucoes">
											<a href="#create-info" id="instrucoes">Instructions</a>
											<p><span>Procedures and options for filling</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo1-tab" aria-labelledby="passo1-link">
											<a href="#create-basic" id="passo1-link">Step 1</a>
											<p><span>Information of the Entity</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo2-tab" aria-labelledby="passo2-link">
											<a href="#create-state" id="passo2-link">Step 2</a>
											<p><span>Status of compliance</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo3-tab" aria-labelledby="passo3-link">
											<a href="#create-technical" id="passo3-link">Step 3</a>
											<p><span>Preparation of this statement of accessibility</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo4-tab" aria-labelledby="passo4-link">
											<a href="#create-contact" id="passo4-link">Step 4</a>
											<p><span>Contact and request of information regarding the <span class="entity-target-website">Website</span> <span class="entity-target-app" hidden>mobile application</span></span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo5-tab" aria-labelledby="passo5-link">
											<a href="#create-seal" id="passo5-link">Step 5</a>
											<p><span>Other evidence</span></p>									
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo6-tab" aria-labelledby="passo6-link">
											<a href="#create-closing" id="passo6-link">Step 6</a>
											<p><span>Denunciation of situations of discrimination</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="previsualizar-tab" aria-labelledby="previsualizar-link">
											<a href="#preview" id="previsualizar-link" data-action="statement_preview">Preview</a>
											<p><span>Preview and download the statement of accessibility</span></p>
										</div>
									</li>
								</ol>
							</div>
						</nav>
					  

						<form name="create_accessibility_statement_form">
						
						<div tabindex="0" role="tabpanel" id="instrucoes-tab" aria-labelledby="create-info" class="tab-passos">

							
								<h3 id="create-info">Instructions</h3>
								<h2>Procedures and options for filling out the form</h2>
							
							<div>
								<div class="group">

									<div class="box">
										<div class="box-i">
											<p>											
											To generate the Statement of Accessibility and Usability, a Generator was developed, through which the filling of a form leads you through the sections of the statement and which, in the end, provides a page ready to be published in your Website.
											</p>

											<p>
											Therefore, to obtain the statement, you must follow the following steps:
											</p>

											<ol>
												<li>
													All documents that you wish to mention in the Statement of Accessibility and Usability must be previously published online, as the statement only includes hyperlink to these documents, namely;
														<ul>
															<li>
															Automatic evaluation report obtained in <a href="https://accessmonitor.acessibilidade.gov.pt/" target="_blank">accessMonitor</a>, for example;
															<li>
															Checklist for collecting evidence from manual assessments - <a href="https://amagovpt.github.io/kit-selo/checklists/en/checklist-10aspects.html" target="_blank">10 critical aspects of functional accessibility</a>;</li>
															<li>Evidence collection checklists for manual assessments – <a href="https://amagovpt.github.io/kit-selo/checklists/en/checklist-content.html" target="_blank">Content</a> and <a href="https://amagovpt.github.io/kit-selo/checklists/en/checklist-transaction.html" target="_blank">Transaction</a>;</li>
															<li>
															Report of usability testing with people with disabilities, namely for the <a href="https://selo.usabilidade.gov.pt/selo-ouro " target="_blank">Gold Seal</a>.</li>
														</ul>
												</li>
												<li>
													Fill in, step by step, the form below or load a previous version and resume filling it;
												</li>
												<li>
													At the end, you can preview and return to the form as many times as you need;
												</li>
												<li>
													When you consider that the statement is completed, you can download the HTML code and paste it in a page of your Website. This page only contains the structured HTML. The style is the style of your Website. 
												</li>
												<li>
													The HTML document is built to be read by a machine - therefore, do not change the page’s structure.
												</li>
											</ol>
										</div>
									</div>
								  
								</div>
							</div>
						 
							<br />
							
							<hr aria-hidden="true" />

							<aside class="box">
								<div class="box-i">
									<div class="button-group-right statement-actions">
										
										<a href="#create-basic" role="button" aria-controls="passo1-tab" id="passo1-button" class="btn_tutorial">Start filling the form
										<span aria-label="next page" role="img" class="icon-arrow-bullets"></span>
										</a>
										
										
									</div>
								</div>
	
								<div class="box-i">

									<div class="button-group-right statement-actions">
										<div class="nota instrucoes">
										<b>Already have a Statement?</b><br>
										You can also start or resume filling from a previous version saved on your computer (file) or published online (URL).
										</div>

										<button type="button" data-action="load_from_html" id="fileLoadButton" class="btn_tutorial btn_tutorial_gray dist-drt" title="Fill in the statement from a file">
											From a file
											<span aria-hidden="true" class="icon-arrow-upload"></span>
										</button>
										<input type="file" id="fileLoadInput" name="file" style="display: none"/>
										<button type="button" data-action="load_from_url" id="urlLoadButton" class="btn_tutorial btn_tutorial_gray" title="Fill in the statement from an URL">
											From an URL
											<span aria-hidden="true" class="icon-arrow-url"></span>
										</button>
									</div>
								</div>
							</aside>

							<p>
								<small><b>Note:</b><br />
								This statement of accessibility and usability model was created by <abbr title="Agência para a Modernização Administrativa, I.P">ARTE</abbr> - Agência para a Reforma Tecnológica do Estado, I.P. [Agency for the Technological Reform of the State], within the scope of the powers granted by the Decree-Law no. 83/2018, of 19 October.)
								</small>						
							</p>
						</div>

						<div tabindex="0" role="tabpanel" id="passo1-tab" aria-labelledby="create-basic" hidden="" class="tab-passos">
							
								<h3 id="create-basic">Step 1</h3>
								<h2>Information of the Entity</h2>
							

							<div>
								<div class="group">
									<p>
										The
										<select id="entity-gender" style="display:none;" title="Introduza o artigo feminino ou masculino concordante com o nome da entidade">
											<option value="O" selected="selected">O</option>
										</select>
										<input id="entity-name" class="form40" title="Fill in the name of the entity" type="text" placeholder="name of the entity"/>
										undertakes to provide
										<br />
										<select class="form40" id="entity-target" title="This statement is for your website or mobile application?" >
										  <option value="[_______________]" disabled="disabled" selected="selected">select option</option>
										  <option value="website">your website</option>
										  <option value="app">your mobile application</option>
										</select>
										<span class="entity-target-website">
										  <input class="form60" id="entity-target-name" title="name of the website" type="text" placeholder="name of the website"/>
										  <br />located at the URL 
										  <input
											class="form60"
											id="entity-target-url"
											title="Enter the website address"
											type="url"
											placeholder="http://"
										  />
										</span>
										<span class="entity-target-app" hidden>
										  <input
											class="form60"
											id="entity-target-app-name"
											title="Enter the name of the mobile application"
											type="text"
											placeholder="name of the mobile application"
										  />
										</span>
										<br />
										, in accordance with the Decree-Law no. 83/2018, of 19 October, which transposes Directive (EU) 2016/2102 of the European Parliament and Council on the accessibility of websites and mobile applications.
															 
													   
																									  
									</p>
								</div>
							</div>
                          
                          

							<hr aria-hidden="true" />

							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-info" role="button" aria-controls="instrucoes-tab">
									  <span aria-label="previous page" role="img" class="icon-arrow-bullets-left"></span>
									  Instructions
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#create-state" role="button" aria-controls="passo2-tab">
									  Step 2
									  <span aria-label="next page" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>

						</div>

						<div tabindex="0" role="tabpanel" id="passo2-tab" aria-labelledby="create-state" hidden="" class="tab-passos">
							
								<h3 id="create-state">Step 2</h3>
								<h2>Status of compliance</h2>
							

							<div>
								<p>
									<span class="entity-target-website">This Website</span>
									<span class="entity-target-app" hidden>This mobile application</span> 
									is &nbsp;
									<select class="form40" id="conformance-status" title="compliance level">
										<option value="[_______________]" disabled="disabled" selected="selected">select option</option>
										<option value="full">fully compliant</option>
										<option value="partial">partially compliant</option>
										<option value="non">noncompliant</option>
									</select> 
									with the Decree-law no. 83/2018, of 19 October.
								</p>

								<div name="non-full-conformance" hidden>
									<p>
									The noncompliance and/or exemptions are indicated below.
									</p>
									<h3 class="label">Non-accessible content</h3>
									<p>
									A. Enumeration of the 
									<strong>sections/contents/functions</strong>
									<span class="entity-target-website">of the Website</span>
									<span class="entity-target-app" hidden>of the mobile application</span>
									which are not yet accessible:
		  
										 
									</p>

									<fieldset class="group naoacessivel">
										<legend class="visuallyhidden">
										  Section/Content/Function
										</legend>
										<div class="field line">
											<label for="accstmnt_non_conformance_sections_1">Section/Content/Function 1</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_sections_1" name="accstmnt_non_conformance_sections"/>
										</div>
										<div class="field proto">
										  <label for="accstmnt_non_conformance_sections_[n]">Section/Content/Function [n]</label>
										  <input class="form80" type="text" id="accstmnt_non_conformance_sections_[n]" name="accstmnt_non_conformance_sections"/>
										  <button type="button" class="remove-line">
											Remove section/content/function
										  </button>
										</div>

										<button type="button" class="add-line" id="accstmnt_non_conformance_sections_button" >
										  Add new section/content/function
										</button>
									</fieldset>

									<p>
									B. <strong>Reasons</strong> (if applicable) why the above-mentioned content is not accessible: (for example, a) nonconformity with the DL no. 83/2018, b) it is outside of the scope of the DL no. 83/2018 or, although within the scope, it is temporarily not accessible due to c) disproportional costs, regarding which was claimed temporary exception within the scope of article 6 of the DL no. 83/2018 and article 5 of the Directive (EU) 2016/2102.
																   
																												
																												  
																
															   
																												  
														  
									</p>

									<fieldset class="group naoacessivel">
										<legend class="visuallyhidden">Reason</legend>
										<div class="field line">
											<label for="accstmnt_non_conformance_reasons_1">Reason 1</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_reasons_1" name="accstmnt_non_conformance_reasons"/>
										</div>
										<div class="field proto">
											<label for="accstmnt_non_conformance_reasons_[n]">Reason [n]</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_reasons_[n]" name="accstmnt_non_conformance_reasons"/>
											<button type="button" class="remove-line">
												Remove reason
											</button>
										</div>

										<button type="button" class="add-line" id="accstmnt_non_conformance_reasons_button">
											Add a new reason
										</button>
									</fieldset>

									<p>
										C. <strong>Accessible alternatives</strong> to the constraints mentioned in A. and B. of this section (whenever appropriate):
									</p>

									<fieldset class="group naoacessivel">
										<legend class="visuallyhidden">
											Accessible alternative 
										</legend>
										<div class="field line">
											<label for="accstmnt_non_conformance_alternatives_1">Accessible alternative 1</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_alternatives_1" name="accstmnt_non_conformance_alternatives"/>
										</div>
										<div class="field proto">
											<label for="accstmnt_non_conformance_alternatives_[n]">Accessible alternative [n]</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_alternatives_[n]" name="accstmnt_non_conformance_alternatives"/>
											<button type="button" class="remove-line">
												Remove accessible alternative
											</button>
										</div>

										<button type="button" class="add-line" id="accstmnt_non_conformance_alternatives_button">
											Add a new accessible alternative
										</button>
									</fieldset>
								</div>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-basic" role="button" aria-controls="passo1-tab">
									  <span aria-label="previous page" role="img" class="icon-arrow-bullets-left"></span>
									  Step 1
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#create-technical" role="button" aria-controls="passo3-tab">
									  Step 3
									  <span aria-label="next page" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="passo3-tab" aria-labelledby="create-technical" hidden="" class="tab-passos">
							
								<h3 id="create-technical">Step 3</h3>
								<h2>
								  Preparation of this statement of accessibility
								</h2>
							

							<div>
								<p>
								  This statement was updated on 
								  <input
									type="date"
									id="accstmt_date"
									class="form40 today"
									title="Enter the creation or update date of the Statement"
								  />.
								</p>

								<p>
								  In accordance with article 9 of the DL no. 83/2018, entities must adopt the following monitoring procedures. Procedures A) and B) are mandatory. Procedure C) is recommended.
																   
																										 
										 
								</p>

								<hr aria-hidden="true" />

								<h3>
								  A. Automatic assessment <br /><small>(Mandatory filling)</small>
											 
		   
								</h3>

								<p>
								 According to subparagraph a) of paragraph 1 of article 9 of the Decree-law no. 83/2018, this type of analysis is mandatory and must be carried out according to certain conditions.
																											 
																										 
								</p>

			   
																								 
													  
			   

								<fieldset>
									<legend>
										Did you carry out any type of assessment using, for this purpose, automatic/semiautomatic tools?
													
									</legend>
									<select class="form40" id="accstmnt_tools">
										<option value="[_______________]" disabled="disabled" selected="selected">Select option</option>
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
								</fieldset>

								<div name="with_tools" hidden>
									<p>
									If you carried out automatic assessments, include the date in which they were held, the name of the tool or tools used, the sample or samples of the pages used, the results achieved and the hyperlinks for the documentation of the analysis carried out.
														  
														 
																   
															  
									</p>

									<fieldset id="accstmnt_assessment_with_tools" class="group">
										<div class="field line">
											<p>
												<b>Automatic Assessment 1</b>
											</p>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_data_1"
												  >Date of the assessment</label
												>
												<input 
												  class="form40"
												  type="date"
												  id="accstmnt_assessment_with_tools_data_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_title_1"
												  >Title of the report</label
												>
												<input
												  class="form100"
												  type="text"
												  id="accstmnt_assessment_with_tools_title_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label
												  for="accstmnt_assessment_with_tools_address_1"
												  >Web address of the report</label
												>
												<input
												  class="form100"
												  type="url"
												  id="accstmnt_assessment_with_tools_address_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_tool_1"
												  >Tool</label
												>
												<input
												  class="form80"
												  type="text"
												  id="accstmnt_assessment_with_tools_tool_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_pages_1"
												  >Number of pages</label
												>
												<input
												  class="form10"
												  type="number"
												  id="accstmnt_assessment_with_tools_pages_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_report_1"
												  >Summary of results</label
												>
												<textarea
												  class="form100"
												  id="accstmnt_assessment_with_tools_report_1"
												  name="accstmnt_assessment_with_tools_data"
												  rows="3"
												  required
												  placeholder="(Example) In a total of 86 pages, a score of 9.6 was achieved in the AccessMonitor scale (1-10), having obtained the following levels of conformity in 75% of the pages, which pass the battery of tests for level A, 50% pass the tests for AA and 25% the tests for AAA. 25% did not pass the battery of tests."
												></textarea>
											</div>
										</div>

										<div class="field proto extra">
										  <p>
											<b>Automatic Assessment [n] </b>
										  </p>
										  <div class="field">
											<label for="accstmnt_assessment_with_tools_data_[n]"
											  >Date of the assessment</label
											>
											<input
											  class="form40"
											  type="date"
											  id="accstmnt_assessment_with_tools_data_[n]"
											  name="accstmnt_assessment_with_tools_data"
											  required
											/>
											</div>
											<div class="field">
												<label
												  for="accstmnt_assessment_with_tools_title_[n]"
												  >Title of the report</label
												>
												<input
												  class="form100"
												  type="text"
												  id="accstmnt_assessment_with_tools_title_[n]"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label
												  for="accstmnt_assessment_with_tools_address_[n]"
												  >Web address of the report</label
												>
												<input
												  class="form100"
												  type="url"
												  id="accstmnt_assessment_with_tools_address_[n]"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_tool_[n]"
												  >Tool</label
												>
												<input
												  class="form80"
												  type="text"
												  id="accstmnt_assessment_with_tools_tool_[n]"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label
												  for="accstmnt_assessment_with_tools_pages_[n]"
												  >Number of pages</label
												>
												<input
												  class="form10"
												  type="number"
												  id="accstmnt_assessment_with_tools_pages_[n]"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label
												  for="accstmnt_assessment_with_tools_report_[n]"
												  >Summary of results</label
												>
												<textarea
												  class="form100"
												  id="accstmnt_assessment_with_tools_report_[n]"
												  name="accstmnt_assessment_with_tools_data"
												  rows="3"
												  required
												></textarea>
											</div>
											<button type="button" class="remove-line">
												Remove automatic assessment
											</button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="accstmnt_assessment_with_tools_button"
										>
										  Add another automatic assessment
										</button>
									</fieldset>
								</div>

								<div name="without_tools" hidden>
									<p>
									If you did not carry out any automatic assessment, explain the reasons for not doing so:
													
									</p>

									<fieldset
									id="accstmnt_assessment_without_tools"
									class="group"
									>
										<div class="field line">
										  <label for="accstmnt_assessment_without_tools_1"
											><b>Reason 1</b></label
										  >
										  <input
										    class="form100"
											type="text"
											id="accstmnt_assessment_without_tools_1"
											name="accstmnt_assessment_without_tools"
										  />
										</div>

										<div class="field proto">
										  <label for="accstmnt_assessment_without_tools_[n]"
											><b>Reason [n]</b></label
										  >
										  <input
										    class="form100"
											type="text"
											id="accstmnt_assessment_without_tools_[n]"
											name="accstmnt_assessment_without_tools"
										  />
										  <button type="button" class="remove-line">
											Remove reason
										  </button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="accstmnt_assessment_without_tools_button"
										>
										  Add another reason
										</button>
									</fieldset>
								</div>

								<hr aria-hidden="true" />

								<h3>
									B. Manual assessment carried out based on the checklist
								</h3>
								<p>
									According to subparagraph b) of paragraph 1 of article 9 of the Decree-law no. 83/2018, this type of analysis is mandatory and must be carried out according to certain conditions.
								</p>

								<fieldset>
									<legend>
									Did you carry out any type of manual assessment based on the 
									<a
									  href="https://amagovpt.github.io/kit-selo/checklists/"
									  target="_blank"
									  >checklist for Websites (available on ARTE's GitHub; opens in a new window)</a
										 
									>?
									</legend>
									<select class="form40" id="accstmnt_manual">
										<option value="[_______________]" disabled="disabled" selected="selected">select option</option>
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
								</fieldset>

								<div name="with_manual" hidden>
									<p>
										If you carried out a manual assessment according to the checklist mentioned on 
											   
		   
									<a href="https://amagovpt.github.io/kit-selo/checklists/checklist-10aspetos.html">10 accessibility critical aspects</a>, 
									include the result (of the total applicable heuristics which are met) and the hyperlink for the support report of the correspondent analysis. 
														 
															
																 
				   
									<br>
										If you carried out other manual assessments, mention the best results achieved and provide a hyperlink for the correspondent support report to the analysis.
																										 
																									   
				  
									</p>

									<fieldset
									id="accstmnt_assessment_with_manual"
									class="group"
									>
										<div class="field line">
										  <p>
											<b>Manual Assessment 1</b><br /><small
											  >(All fields are mandatory)</small
								 
											>
										  </p>
										  <div class="field">
											<label for="accstmnt_assessment_with_manual_data_1"
											  >Date of the assessment</label
											>
											<input
											  class="form40" 
											  type="date"
											  id="accstmnt_assessment_with_manual_data_1"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label for="accstmnt_assessment_with_manual_title_1"
											  >Title of the support report</label
											>
											<input
											  class="form100" 
											  type="text"
											  id="accstmnt_assessment_with_manual_title_1"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_address_1"
											  >Web address of the support report</label
											>
											<input
											  class="form100" 
											  type="url"
											  id="accstmnt_assessment_with_manual_address_1"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_sample_1"
											  >Sample used in the manual assessment (number of pages)</label
							 
											>
											<input
											  class="form10" 
											  type="number"
											  id="accstmnt_assessment_with_manual_sample_1"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_satisfied_1"
											  >Of the checklist, how many heuristics are met?</label
								
											>
											<input
											  class="form10" 
											  type="number"
											  id="accstmnt_assessment_with_manual_satisfied_1"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_heuristics_1"
											  >Of the checklist, how many heuristics are applicable?</label
								
											>
											<input
											  class="form10" 
											  type="number"
											  id="accstmnt_assessment_with_manual_heuristics_1"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										</div>

										<div class="field proto extra">
										  <p>
											<b>Manual Assessment [n]</b><br /><small
											  >(All fields are mandatory)</small
								 
											>
										  </p>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_data_[n]"
											  >Date of the assessment</label
											>
											<input
											  class="form40" 
											  type="date"
											  id="accstmnt_assessment_with_manual_data_[n]"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_title_[n]"
											  >Title of the support report</label
											>
											<input
											  class="form100" 
											  type="url"
											  id="accstmnt_assessment_with_manual_title_[n]"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_address_[n]"
											  >Web address of the support report</label
											>
											<input
											  class="form100" 
											  type="url"
											  id="accstmnt_assessment_with_manual_address_[n]"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_sample_[n]"
											  >Sample used in the manual assessment (number of pages)</label
							 
											>
											<input
											  class="form10" 
											  type="number"
											  id="accstmnt_assessment_with_manual_sample_[n]"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_satisfied_[n]"
											  >Of the checklist, how many heuristics are met?</label
								
											>
											<input
											  class="form10" 
											  type="number"
											  id="accstmnt_assessment_with_manual_satisfied_[n]"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_heuristics_[n]"
											  >Of the checklist, how many heuristics are applicable?</label
								
											>
											<input
											  class="form10" 
											  type="number"
											  id="accstmnt_assessment_with_manual_heuristics_[n]"
											  name="accstmnt_assessment_with_manual_data"
											  required
											/>
										  </div>
										  <button type="button" class="remove-line">
											Remove manual assessment
										  </button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="accstmnt_assessment_with_manual_button"
										>
										  Add another manual assessment
										</button>
									</fieldset>
								</div>

								<div name="without_manual" hidden>
									<p>
									If you did not carry out any manual assessment, explain the reasons for not doing so:
												   
									</p>

									<fieldset
									id="accstmnt_assessment_without_manual"
									class="group"
									>
										<div class="field line">
										  <label for="accstmnt_assessment_without_manual_1"
											><b>Reason 1</b></label
										  >
										  <input
										    class="form100" 
											type="text"
											id="accstmnt_assessment_without_manual_1"
											name="accstmnt_assessment_without_manual"
										  />
										</div>

										<div class="field proto">
										  <label for="accstmnt_assessment_without_manual_[n]"
											><b>Reason [n]</b></label
										  >
										  <input
										    class="form100" 
											type="text"
											id="accstmnt_assessment_without_manual_[n]"
											name="accstmnt_assessment_without_manual"
										  />
										  <button type="button" class="remove-line">
											Remove reason
										  </button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="ccstmnt_assessment_without_manual_button"
										>
										  Add another reason
										</button>
									</fieldset>
								</div>

								<hr aria-hidden="true" />

								<h3>C. Usability tests with people with disabilities:</h3>
								<p>
								  According to subparagraph c) of paragraph 1 of article 9 of the Decree-law no. 83/2018, this type of analysis is recommended.
															
					  
								</p>

								<fieldset>
									<legend>
										Did you carry out any type of tests with users?
									</legend>
									<select class="form40" id="accstmnt_users">
										<option value="[_______________]" disabled="disabled" selected="selected">Select option</option>
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
								</fieldset>

								<div name="with_users" hidden>
									<p>
									If you carried out usability tests with people with disabilities, list them below, indicating the tasks, the participants, a summary of the main conclusions and a link for the study report.
																 
																
														
									</p>

									<fieldset
									id="accstmnt_assessment_with_users"
									class="group"
									>
										<div class="field line">
										  <p>
											<label for="accstmnt_assessment_with_users_1"
											  ><b>Assessment with Users 1</b><br /><small
												>(All fields are mandatory)</small
								
											  ></label
											>
										  </p>
										  <div class="field">
											<label for="accstmnt_assessment_with_users_data_1"
											  >Date of the assessment</label
											>
											<input
											  class="form40" 
											  type="date"
											  id="accstmnt_assessment_with_users_data_1"
											  name="accstmnt_assessment_with_users_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label for="accstmnt_assessment_with_users_title_1"
											  >Title of the study report</label
											>
											<input
											  class="form100" 
											  type="text"
											  id="accstmnt_assessment_with_users_title_1"
											  name="accstmnt_assessment_with_users_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label for="accstmnt_assessment_with_users_url_1"
											  >URL of the study report</label
											>
											<input
											  class="form100" 
											  type="url"
											  id="accstmnt_assessment_with_users_url_1"
											  name="accstmnt_assessment_with_users_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_users_participants_1"
											  >Participants</label
											>
											<input
											  class="form100" 
											  type="text"
											  id="accstmnt_assessment_with_users_participants_1"
											  name="accstmnt_assessment_with_users_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label for="accstmnt_assessment_with_users_tasks_1"
											  >Tasks/Process</label
											>
											<textarea
											  class="form100" 
											  id="accstmnt_assessment_with_users_tasks_1"
											  name="accstmnt_assessment_with_users_data"
											  rows="3"
											  required
											></textarea>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_users_results_1"
											  >Main results (summary):</label
											>
											<textarea
											  class="form100" 
											  id="accstmnt_assessment_with_users_results_1"
											  name="accstmnt_assessment_with_users_data"
											  required
											></textarea>
										  </div>
										</div>

										<div class="field proto extra">
										  <p>
											<label for="accstmnt_assessment_with_users_[n]"
											  ><b>Assessment with Users [n]</b><br /><small
												>(All fields are mandatory)</small
								
											  ></label
											>
										  </p>
										  <div class="field">
											<label for="accstmnt_assessment_with_users_data_[n]"
											  >Date of the assessment</label
											>
											<input
											  class="form40" 
											  type="date"
											  id="accstmnt_assessment_with_users_data_[n]"
											  name="accstmnt_assessment_with_users_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_users_title_[n]"
											  >Title of the study report</label
											>
											<input
											  class="form100" 
											  type="text"
											  id="accstmnt_assessment_with_users_title_[n]"
											  name="accstmnt_assessment_with_users_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label for="accstmnt_assessment_with_users_url_[n]"
											  >URL of the study report</label
											>
											<input
											  class="form100" 
											  type="url"
											  id="accstmnt_assessment_with_users_url_[n]"
											  name="accstmnt_assessment_with_users_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_users_participants_[n]"
											  >Participants</label
											>
											<input
											  class="form100" 
											  type="text"
											  id="accstmnt_assessment_with_users_participants_[n]"
											  name="accstmnt_assessment_with_users_data"
											  required
											/>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_users_tasks_[n]"
											  >Tasks/Process</label
											>
											<textarea
											  class="form100" 
											  id="accstmnt_assessment_with_users_tasks_[n]"
											  name="accstmnt_assessment_with_users_data"
											  rows="2"
											  required
											></textarea>
										  </div>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_users_results_[n]"
											  >Main results (summary):</label
											>
											<textarea
											  class="form100" 
											  id="accstmnt_assessment_with_users_results_[n]"
											  name="accstmnt_assessment_with_users_data"
											  required
											></textarea>
										  </div>
										  <button type="button" class="remove-line">
											Remove assessment with users
										  </button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="accstmnt_assessment_with_users_button"
										>
										  Add another assessment with users
										</button>
									</fieldset>
								</div>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-state" role="button" aria-controls="passo2-tab">
									  <span aria-label="previous page" role="img" class="icon-arrow-bullets-left"></span>
									  Step 2
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#create-contact" role="button" aria-controls="passo4-tab">
									  Step 4
									  <span aria-label="next page" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="passo4-tab" aria-labelledby="create-contact" hidden="" class="tab-passos">
							
								<h3 id="create-contact">Step 4</h3>
								<h2>
								  Contact and request of information regarding 
								  <span class="entity-target-website">the Website</span>
								  <span class="entity-target-app" hidden
									>the mobile application</span
								  >
								</h2>
							
							<div>
								<p>
								  If you wish to contact 
								  <span class="entity_article">the</span>
								  <span class="entity_description">Entity</span>
								  due to this
								  <!--span class="entity-target-website">do</span>
								  <span class="entity-target-app" hidden>da</span>
								  presente-->
								  <span class="entity-target-website">Website</span>
								  <span class="entity-target-app" hidden
									>web application</span
								  >, to submit suggestions or report any difficulty regarding accessibility to any document, page or service provided, please use one of the following contacts:
														   
																   
															   
													
								</p>

								<fieldset class="group">
									<div class="field line">
										<label for="accstmnt_orginfo_contact_1"
										  ><b>Contact 1</b></label
										>
										<div class="field">
										  <label for="accstmnt_orginfo_contacts_1"
											>Type (e.g. email, telephone)</label
																	   
										  >
										  <input
										    class="form80" 
											type="text"
											id="accstmnt_orginfo_contacts_1"
											name="accstmnt_orginfo_contacts"
										  />
										</div>
										<div class="field">
										  <label for="accstmnt_orginfo_element_1"
											>Contact</label
										  >
										  <input
										    class="form80" 
											type="text"
											id="accstmnt_orginfo_element_1"
											name="accstmnt_orginfo_contacts"
										  />
										</div>
									</div>
									<div class="field proto extra">
										<p>
										  <label for="accstmnt_orginfo_contact_[n]"
											><b>Contact [n]</b></label
										  >
										</p>
										<div class="field">
										  <label for="accstmnt_orginfo_contacts_[n]"
											>Type (e.g. email, telephone)</label
																	   
										  >
										  <input
										    class="form80" 
											type="text"
											id="accstmnt_orginfo_contacts_[n]"
											name="accstmnt_orginfo_contacts"
										  />
										</div>
										<div class="field">
										  <label for="accstmnt_orginfo_element_[n]"
											>Contact</label
										  >
										  <input
										    class="form80" 
											type="text"
											id="accstmnt_orginfo_element_[n]"
											name="accstmnt_orginfo_contacts"
										  />
										</div>
										<button type="button" class="remove-line">
										  Remove contact
										</button>
									</div>

									<button
									type="button"
									class="add-line"
									id="accstmnt_orginfo_button"
									>
										Add contact
									</button>
								</fieldset>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-technical" role="button" aria-controls="passo3-tab">
									  <span aria-label="previous page" role="img" class="icon-arrow-bullets-left"></span>
									  Step 3
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#create-seal" role="button" aria-controls="passo5-tab">
									  Step 5
									  <span aria-label="next page" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="passo5-tab" aria-labelledby="create-seal" hidden="" class="tab-passos">
							
								<h3 id="create-seal">Step 5</h3>
								<h2>
								  Other evidence<!-- / efforts to make content more accessible and usable-->
											  
								</h2>
							
							<div>
								<fieldset class="group">
								  <div class="field" id="seal-awarded">
									<legend class="label">
									 Do you hold a usability and accessibility seal?
									</legend>
									<div class="radio-field">
									  <input
										type="radio"
										name="entity-seal"
										id="entity-seal-no"
										checked="checked"
										value="no" 
									  />
									  <label for="entity-seal-no">No</label>
									</div>
									<div class="radio-field">
									  <input
										type="radio"
										name="entity-seal"
										id="entity-seal-bronze"
										value="bronze"
									  />
									  <label for="entity-seal-bronze">Bronze</label>
									</div>

									<div class="radio-field">
									  <input
										type="radio"
										name="entity-seal"
										id="entity-seal-prata"
										value="prata"
									  />
									  <label for="entity-seal-prata">Silver</label>
									</div>

									<div class="radio-field">
									  <input
										type="radio"
										name="entity-seal"
										id="entity-seal-ouro"
										value="ouro"
									  />
									  <label for="entity-seal-ouro">Gold</label>
									</div>
								  </div>
								</fieldset>

								<br />
									
								<div class="group">
								  <div class="field">
									<label
									  for="accstmnt_assessment_additional_evidence_data"
									  >Add another evidence</label
									>
									<textarea
									  class="form100" 
									  id="accstmnt_assessment_additional_evidence_data"
									  rows="3"
									></textarea>
								  </div>
								</div>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-contact" role="button" aria-controls="passo4-tab">
									  <span aria-label="previous page" role="img" class="icon-arrow-bullets-left"></span>
									  Step 4
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#create-closing" role="button" aria-controls="passo6-tab">
									  Step 6
									  <span aria-label="next page" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="passo6-tab" aria-labelledby="create-closing" hidden="" class="tab-passos">
							
							<h3 id="create-closing">Step 6</h3>
							<h2>
							  Denunciation of situations of discrimination
							</h2>
							
							<div>
								<div class="group">
								  <p>
									According to article 13.1 of Decree-Law no. 83/2018, of 19 October, whenever a person with disability is treated less favourably than another person in a comparable situation has been or will be treated, which constitutes a discriminatory practice against persons with disabilities, provided for and punished under the terms of 
																 
															 
															  
																
																   
										
									<a
									  href="http://data.dre.pt/eli/lei/46/2006/08/28/p/dre/pt/html"
									  >article 4 of Law no. 46/2006, of 28 August</a
									>, that person may, in accordance with the provisions of 
					
									<a
									  href="https://data.dre.pt/eli/dec-lei/34/2007/02/15/p/dre/pt/html"
									  >Decree-Law no. 34/2007, of 15 February</a
									> file a complaint.
								  </p>
								  <p>
									The National Institute for Rehabilitation (INR, I.P.), provides a 
						 
									<a
									  href="http://www.inr.pt/resultados-de-pesquisa/-/journal_content/56/11309/45065?p_p_auth=wje2GjQi"
									  >form to report situations of discrimination</a
									>, forwarding the complaints submitted to the competent authorities. Every year, the INR, I.P. prepares an annual report on the application of the law that prohibits and punishes discrimination on the grounds of disability and the existence of an aggravated health risk (Law no. 46/2006, of 28 August).
															  
												  
																  
															  
																   
						  
								  </p>
								</div>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-seal" role="button" aria-controls="passo5-tab">
									  <span aria-label="previous page" role="img" class="icon-arrow-bullets-left"></span>
									  Step 5
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#preview" role="button" aria-controls="previsualizar-tab">
									  Preview
									  <span aria-label="next page" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>
					  
						<div tabindex="0" role="tabpanel" id="previsualizar-tab" aria-labelledby="preview" hidden="" class="tab-passos">
							
								<h3 id="preview">Preview</h3>
								<h2>
								  Preview and download the statement of accessibility
								</h2>
							
							<div>
								<div class="group">
									<p>Check that the information below is correct. You can also go back to each step and edit the respective fields.</p>
									<p>If you believe that all data is correct, you can download the file in HTML format.
									When copying its contents to the page where you want to publish the statement, this will keep the style of your website.</p>
									<p>If you prefer to leave this page and finish filling out the statement later, you can also download the file to your computer and, whenever you want, you can load it on the home page of this Generator and resume editing the statement.</p>
								</div>
									
						
								<!--section class="page preview" hidden="hidden">
									<aside class="box box-example">
										<header class="box-h box-h-example">
											Visualização da sua declaração de acessibilidade
										</header-->

								<div class="box-i discard">
									<div id="statement_generated">
										<div id="statement_header">
											<h1>Statement of Accessibility and Usability</h1>
											<p>
												The <!--(<span class="mr mr-e-intro">(<span data-print="entity-gender"></span>)</span>
												(<span class="mr mr-e-name">)(--><span data-print="entity-name"></span>
												undertakes to provide 
												<span class="target-type">[_______________]</span>
												<a href="#" class="siteurl"><span class="mr mr-t-desc"><span class="target-name">[_______________]</span></span></a>, 
												
												in accordance with the Decree-Law no. 83/2018, of 19 October, which transposes Directive (EU) 2016/2102 of the European Parliament and Council on the accessibility of websites and mobile applications.
																							  
																															   
																										 
											</p>
										</div>

										<div id="statement-create-state">
											<h2 id="n1">I. Status of compliance</h2>
											<div id="conformance-status-full">
												<p class="capFL">
													<span class="target-type">[_______________]</span>
													<a href="#" class="siteurl"><span class="target-name">[_______________]</span></a>
													
										 
											
							
					 
													<span data-print="entity-name"></span> is
													<span class="mr mr-conformance-status"
													  ><span class="conformance-output"
														>[_______________]</span
													  ></span
													>
													with the Decree-law no. 83/2018, of 19 October.
												</p>
											</div>

											<div id="conformance-status-non-conformance" data-if="accstmnt_non_conformance_sections">
												<p>
													The noncompliance and/or exemptions are indicated below.
												</p>
												<h3>Noncompliance and/or exemptions</h3>
												<p>
												A. Enumeration of the 
												<strong>sections / contents / functions</strong>
												of <span class="target-type">the Website</span>
												which are not yet accessible:
												</p>
												<ul id="non-conformance-sections" class="mr mr-nonconf-sections" data-print="accstmnt_non_conformance_sections" data-printfilter="capitalize">
												</ul>
												<div id="conformance-status-non-conformance-reasons" data-if="accstmnt_non_conformance_reasons">
													<p>
														B. <strong>Reasons </strong> why the above-mentioned content is not accessible:
													</p>
													<ul
													  id="non-conformance-reasons"
													  class="mr mr-nonconf-reasons"
													  data-print="accstmnt_non_conformance_reasons"
													></ul>
												</div>
												<div id="conformance-status-non-conformance-alternatives" data-if="accstmnt_non_conformance_alternatives">
													<p>
													  C. <strong>Accessible alternatives</strong> to the constraints mentioned in A. and B. of this section:
																								 
													</p>
													<ul
													  id="non-conformance-alternatives"
													  class="mr mr-nonconf-alternatives"
													  data-print="accstmnt_non_conformance_alternatives"
													></ul>
												</div>
											</div>
										</div>

										<div id="statement-elaboration">
											<h2 id="n2">
											  II. Preparation of this statement of accessibility
						
											</h2>
											<p>
											  This statement was updated on 
											  <span class="mr mr-date"
												><span
												  data-print="accstmt_date"
												  data-printdefault="DATE"
												>[_______________]</span></span
											  >.
											</p>

											<p>
											  In accordance with article 9 of the DL no. 83/2018, entities must adopt the following monitoring procedures. Procedures A) and B) are mandatory. Procedure C) is recommended.
																										 
																											 
											
											</p>

											<p>
											  <strong
												>A. Automatic assessments carried out</strong
											  >
											</p>
											<div data-if="accstmnt_assessment_with_tools_data">
												<article
												data-print="accstmnt_assessment_with_tools_data"
												id="accstmnt_assessment_with_tools_summary"
												class="mr mr-automatic-summary"
												></article>
											</div>
											<div
											  data-if="accstmnt_assessment_with_tools_data"
											  data-negate
											>
												<p class="capFL">
													<span class="target-type">[_______________]</span> has not been subject to automatic assessment of the accessibility practices.
														
												</p>
											</div>
											<div data-if="accstmnt_assessment_without_tools">
											  <p>
												Reasons for not performing automatic assessments:
						 
											  </p>
											  <ul
												id="accstmnt_assessment_without_tools_list"
												class="mr mr-no-automatic-reasons"
												data-print="accstmnt_assessment_without_tools"
											  ></ul>
											</div>

											<p>
											  <strong>B. Manual assessments carried out:</strong>
											</p>
											<div data-if="accstmnt_assessment_with_manual_data">
											  <article
												data-print="accstmnt_assessment_with_manual_data"
												id="accstmnt_assessment_with_manual_summary"
												class="mr mr-manual-summary"
											  ></article>
											</div>
											<div
											  data-if="accstmnt_assessment_with_manual_data"
											  data-negate
											>
											  <p class="capFL">
												<span class="target-type">[_______________]</span> has not been subject to manual assessment of the accessibility practices.
												   
											  </p>
											</div>
											<div data-if="accstmnt_assessment_without_manual">
											  <p>
												Reasons for not performing manual assessments:
					
											  </p>
											  <ul
												id="accstmnt_assessment_without_manual_list"
												class="mr mr-no-manual-reasons"
												data-print="accstmnt_assessment_without_manual"
											  ></ul>
											</div>

											<p>
												<strong>C. Usability tests with people with disabilities:</strong>
													 
								 
			 
											</p>
											<div data-if="accstmnt_assessment_with_users_data">
												<article
												data-print="accstmnt_assessment_with_users_data"
												id="accstmnt_assessment_with_users_summary"
												class="mr mr-users-summary"
												></article>
											</div>
											<div
											  data-if="accstmnt_assessment_with_users_data"
											  data-negate
											>
											  <p class="capFL">
												<span class="target-type">[_______________]</span> has not yet been tested with disabled users.
										  
											  </p>
											</div>
										</div>

										<div id="statement-contact-block">
											<h2 id="n3">
											  III. Contact and request of information regarding <span class="target-type">[_______________]</span>
										   
											</h2>
											<p>
												To contact, send suggestions, make complaints or request additional information regarding the contents and/or functionalities present on the 
																											   
												<span class="target-type">[_______________]</span>
												of 
			  
				   
									  
										 
						 
					 
												<span data-print="entity-name">[_______________]</span>, please use the following means:
									   
											</p>
											<div
											  id="accstmnt_orginfo_contacts_details"
											  data-if="accstmnt_orginfo_contacts"
											>
											  <article
												data-print="accstmnt_orginfo_contacts"
												id="accstmnt_orginfo_contacts_summary"
												class="mr mr-contacts"
											  >[_______________]</article>
											</div>
										</div>

										<div id="statement-seals-block">
											<h2 id="n4">
											  IV. Other evidence <!-- / efforts to make content more accessible and usable-->
																												
											</h2>
											<article
											  id="accstmnt_seal_summary"
											  data-print="entity-seal"
											></article>
											<div
											  data-if="accstmnt_assessment_additional_evidence_data"
											  data-negate
											>
											  <p><span
												id="accstmnt_seal_summary_empty"
												data-print="entity-seal"
											  >
												
												  The <span data-print="entity-name">[_______________]</span> did not submit, upon the filling of this Statement, other evidence or efforts to make its Website compliance with the accessibility requirements on DL no. 83/2018, of 19 October.
																									   
																								
																										 
																									
																										  
												
											  </span></p>
											</div>
											<div data-if="accstmnt_assessment_additional_evidence_data">
											  <h3>Other evidences</h3>
											  <span class="mr mr-seal-other">
												<p>
												<span
												  id="accstmnt_additional_evidence_summary"
												  data-print="accstmnt_assessment_additional_evidence_data"
												></span>
												</p>
											  </span>
											</div>
										</div>

										<div id="statement-closing-block">
											<h2 id="n5">
											  V. Denunciation of situations of discrimination 
											</h2>
											<p>
											  According to article 13.1 of Decree-Law no. 83/2018, of 19 October, whenever a person with disability is treated less favourably than another person in a comparable situation has been or will be treated, which constitutes a discriminatory practice against persons with disabilities, provided for and punished under the terms of 
																										  
																										  
																								 
																									
																											 
								 
											  <a
												href="http://data.dre.pt/eli/lei/46/2006/08/28/p/dre/pt/html"
												>article 4 of Law no. 46/2006, of 28 August</a
											  >, that person may, in accordance with the provisions of 
						
											  <a
												href="https://data.dre.pt/eli/dec-lei/34/2007/02/15/p/dre/pt/html"
												>Decree-Law no. 34/2007, of 15 February</a
											  >, file a complaint.
											</p>
											<p>
											  The National Institute for Rehabilitation (INR, I.P.), provides a <a
							 
			   
												href="http://www.inr.pt/resultados-de-pesquisa/-/journal_content/56/11309/45065?p_p_auth=wje2GjQi"
												>form to report situations of discrimination</a>, forwarding the complaints submitted to the competent authorities. Every year, the INR, I.P. prepares an annual report on the application of the law that prohibits and punishes discrimination on the grounds of disability and the existence of an aggravated health risk (Law no. 46/2006, of 28 August).
																								   
																										  
																								   
																											   
																								
					 
											</p>
										</div>

										<div id="statement-limitations-block"></div>

										<hr aria-hidden="true" />

										<p>
											This Statement of Accessibility and Usability was created with the help of the 
								   
											<a href="https://www.acessibilidade.gov.pt/gerador"
											  >WAI-Tools PT v1.5 Generator</a
											>, developed in the scope of the 
											<a href="https://w3.org/WAI/Tools">WAI-Tools</a> project, of which ARTE is an integral part. The Statement was conceived in accordance with Decree-Law no. 83/2018, of 19 October.
																									
																												   
				   
										</p>
									</div>
								</div>
								
									<!--/aside-->
								
								<div class="box-i end">
									<div class="button-group-right statement-actions">
										<div class="nota instrucoes">
										<p><b>Is your Assessment correct?</b><br>
										If you think so or want to continue later, download the file and save it to your computer. If you need to review something, use the side menu to access the previous steps.</p>
										</div>
										
										<div class="button-group statement-actions">
										  <button type="button" data-action="preview_save_as_html" class="btn_tutorial">
											Download HTML file
											<span aria-hidden="true" class="icon-arrow-download"></span>
										  </button>
										</div>
									</div>
									
								</div>
					
									<small>
										<b>Note:</b><br>
										By pressing the "Download HTML file" button, a file containing the structure of the Assessment of Accessibility and Usability will be saved on your computer.<br>
										<br>
										It is very important that you do not change the structure of the HTML information that we provide here, because it is in a "machine-readable" format and it will be essential for us to locate and consider your Assessment.<br>
										<br>
										If you have completed the filling, copy the code and paste it in the body of the page that will present the Assessment on your website. The style (font colors, sizes, text alignments, ...) are those of your website, that are in your Cascading Style Sheets (CSS) style sheets.<br>
										<br>
										If you have not finished filling out and want to return later, also use the button to save an HTML version of what is already filled in to your computer. With that file, tomorrow, or whenever you want, you can continue at the step where you left off. Just submit it on the first page of this Generator, using the "From a file" option.<br>
									</small>						
								
					
							</div>

						</div>
						
						</form>
	   
	   
	  
	   
	  

					</div>
					
				</section>
				
			</div>
		  
		</section>
