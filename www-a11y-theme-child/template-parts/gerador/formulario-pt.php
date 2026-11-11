<?php
/**
 * Gerador da Declaração de Acessibilidade e Usabilidade: formulário (PT).
 * Markup vindo de amagovpt/a11y-da (gerador/index.html), sem o cabeçalho, o rodapé
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
									Ver Conteúdos da Declaração
								</button>
							</header>

							<div class="box-i gerador" id="tab-menu" role="tablist">
								<ol>
									<li value="0" class="selected">
										<div role="tab" aria-selected="true" aria-controls="instrucoes-tab" aria-labelledby="instrucoes">
											<a href="#create-info" id="instrucoes">Instruções</a>
											<p><span>Procedimentos e opções de preenchimento</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo1-tab" aria-labelledby="passo1-link">
											<a href="#create-basic" id="passo1-link">Passo 1</a>
											<p><span>Informação da entidade</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo2-tab" aria-labelledby="passo2-link">
											<a href="#create-state" id="passo2-link">Passo 2</a>
											<p><span>Estado de conformidade</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo3-tab" aria-labelledby="passo3-link">
											<a href="#create-technical" id="passo3-link">Passo 3</a>
											<p><span>Elaboração da Declaração</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo4-tab" aria-labelledby="passo4-link">
											<a href="#create-contact" id="passo4-link">Passo 4</a>
											<p><span>Contacto e solicitação de informação relativa <span class="entity-target-website">ao sítio Web</span> <span class="entity-target-app" hidden>à aplicação móvel</span></span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo5-tab" aria-labelledby="passo5-link">
											<a href="#create-seal" id="passo5-link">Passo 5</a>
											<p><span>Outras evidências</span></p>									
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="passo6-tab" aria-labelledby="passo6-link">
											<a href="#create-closing" id="passo6-link">Passo 6</a>
											<p><span>Denúncia de situações de discriminação</span></p>
										</div>
									</li>
									<li>
										<div role="tab" aria-selected="false" aria-controls="previsualizar-tab" aria-labelledby="previsualizar-link">
											<a href="#preview" id="previsualizar-link" data-action="statement_preview">Pré-visualizar</a>
											<p><span>Pré-visualização e opção para descarregar a Declaração</span></p>
										</div>
									</li>
								</ol>
							</div>
						</nav>
					  

						<form name="create_accessibility_statement_form">
						
						<div tabindex="0" role="tabpanel" id="instrucoes-tab" aria-labelledby="create-info" class="tab-passos">
							
							<h3 id="create-info">Instruções</h3>
							<h2>Procedimentos e opções de preenchimento</h2>
							
							<div>
								<div class="group">

									<div class="box">
										<div class="box-i">
											<p>
											Para gerar a Declaração de Acessibilidade e Usabilidade foi desenvolvido este Gerador, o qual, mediante o preenchimento de um formulário, o conduz pelas secções da Declaração e proporciona, no final, uma página pronta a publicar no seu sítio Web.
											</p>

											<p>
											Assim, para obter a Declaração, deverá garantir os seguintes passos:
											</p>

											<ol>
												<li>
													Todos os documentos que pretende referenciar na Declaração de Acessibilidade e Usabilidade devem estar previamente elaborados e publicados online, uma vez que naquela apenas existem hiperligações para os mesmos, nomeadamente:
														<ul>
															<li>Relatório da avaliação automática obtida no <a href="https://accessmonitor.acessibilidade.gov.pt/" target="_blank">accessMonitor</a>, por exemplo;</li>
															<li>Lista de verificação de recolha de evidências das avaliações manuais – <a href="https://amagovpt.github.io/kit-selo/checklists/checklist-10aspetos.html" target="_blank">10 aspetos críticos de acessibilidade funcional</a>;</li>
															<li>Listas de verificação de recolha de evidências das avaliações manuais – <a href="https://amagovpt.github.io/kit-selo/checklists/checklist-conteudo.html" target="_blank">Conteúdo</a> e <a href="https://amagovpt.github.io/kit-selo/checklists/checklist-transacao.html" target="_blank">Transação</a>;</li>
															<li>Relatório de testes de usabilidade com pessoas com deficiência, nomeadamente para o <a href="https://selo.usabilidade.gov.pt/selo-ouro" target="_blank">Selo Ouro</a>. </li>
														</ul>
												</li>
												<li>
													Preencher, passo a passo, o formulário que se segue ou carregar uma versão prévia e retomar o seu preenchimento;
												</li>
												<li>
													No final, pode pré-visualizar e guardar o formulário preenchido, podendo voltar quantas vezes precisar;
												</li>
												<li>
													Quando considerar que a Declaração está concluída, pode descarregar o código HTML e colá-lo numa página do seu sítio Web. Esta página contém apenas o HTML estruturado, o estilo será o do próprio sítio Web
												</li>
												<li>
													O documento HTML está construído para ser lido por uma máquina, por isso não deve alterar a estrutura da página que resulta deste Gerador.
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
										
										<a href="#create-basic" id="passo1-button" class="btn_tutorial" role="button" aria-controls="passo1-tab">Preencher declaração
											<span aria-label="página seguinte" role="img" class="icon-arrow-bullets"></span>
										</a>
										
										
									</div>
								</div>
	
								<div class="box-i">

									<div class="button-group-right statement-actions">
										<div class="nota instrucoes">
										<b>Já tem uma Declaração?</b><br>
										Também pode iniciar ou retomar o preenchimento a partir de uma versão prévia e guardada no seu computador (ficheiro) ou publicada online (URL).
										</div>

										<button type="button" data-action="load_from_html" id="fileLoadButton" class="btn_tutorial btn_tutorial_gray dist-drt" title="Carregar declaração a partir de um ficheiro">
											Carregar ficheiro
											<span aria-hidden="true" class="icon-arrow-upload"></span>
										</button>
										<input type="file" id="fileLoadInput" name="file" style="display: none"/>
										<button type="button" data-action="load_from_url" id="urlLoadButton" class="btn_tutorial btn_tutorial_gray" title="Carregar declaração a partir de um Endereço Web">
											Carregar URL
											<span aria-hidden="true" class="icon-arrow-url"></span>
										</button>
									</div>
								</div>
							</aside>

							<p>
								<small><b>Nota:</b><br />
								O presente modelo de Declaração de Acessibilidade e Usabilidade foi criado pela Agência para a Reforma Tecnológica do Estado, I. P (<abbr title="Agência para a Reforma Tecnológica do Estado, I. P">ARTE</abbr>), no âmbito das competências que lhe são atribuídas pelo Decreto-Lei n.º 83/2018, de 19 de outubro. 
								</small>						
							</p>
						</div>

						<div tabindex="0" role="tabpanel" id="passo1-tab" aria-labelledby="create-basic" hidden="" class="tab-passos">
							
							<h3 id="create-basic">Passo 1</h3>
							<h2>Informação da entidade</h2>
						
							<div>
								<div class="group">
									<p>
										<select id="entity-gender" class="form20" title="Introduza o artigo feminino ou masculino concordante com o nome da entidade">
											<option value="[_______________]" disabled="disabled" selected="selected">seleccionar</option>
											<option value="A">A</option>
											<option value="O">O</option>
										</select>
										<input id="entity-name" class="form40" title="Introduza o nome da Entidade" type="text" placeholder="nome da entidade"/>
										compromete-se a disponibilizar
										<br />
										<select id="entity-target" class="form40" title="Esta declaração é para o seu sítio Web ou para a sua aplicação móvel?" >
											<option value="[_______________]" disabled="disabled" selected="selected">seleccionar opção</option>
											<option value="website">o seu sítio Web</option>
											<option value="app">a sua aplicação móvel</option>
										</select>
										<span class="entity-target-website">
										  <input id="entity-target-name" class="form60" title="Introduza o nome do sítio Web" type="text" placeholder="nome do sítio Web"/>
										  <br />localizado no URL
										  <input
											class="form60"
											id="entity-target-url"
											title="Introduza o endereço do sítio Web"
											type="url"
											placeholder="http://"
										  />
										</span>
										<span class="entity-target-app" hidden>
										  <input
											class="form60"
											id="entity-target-app-name"
											title="Introduza o nome da aplicação móvel"
											type="text"
											placeholder="nome da aplicação móvel"
										  />
										</span>
										<br />
										em conformidade com o Decreto-Lei n.º 83/2018, de 19 de
										outubro, que transpõe a Diretiva (UE) 2016/2102 do
										Parlamento Europeu e do Conselho, relativa à
										acessibilidade dos sítios Web e das aplicações móveis.
									</p>
								</div>
							</div>
                          
                          

							<hr aria-hidden="true" />

							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions" >
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-info" role="button" aria-controls="instrucoes-tab">
									  <span aria-label="página anterior" role="img" class="icon-arrow-bullets-left"></span>
									  Instruções
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions" >
									<a class="button btn_tutorial btn_tutorial" aria-controls="passo2-tab" href="#create-state" role="button">
									  Passo 2
									  <span aria-label="página seguinte" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>

						</div>

						<div tabindex="0" role="tabpanel" id="passo2-tab" aria-labelledby="create-state" hidden="" class="tab-passos">
							
							<h3 id="create-state">Passo 2</h3>
							<h2>Estado de conformidade</h2>
							
							<div>
								<p>
									<span class="entity-target-website">Este sítio Web</span>
									<span class="entity-target-app" hidden>Esta aplicação móvel</span> 
									está &nbsp;
									<select id="conformance-status" class="form40" title="Nível de conformidade a declarar?">
										<option value="[_______________]" disabled="disabled" selected="selected">seleccionar opção</option>
										<option value="full">plenamente conforme</option>
										<option value="partial">parcialmente conforme</option>
										<option value="non">não conforme</option>
									</select> 
									para com o Decreto-Lei n.º 83/2018, de 19 de outubro.
								</p>

								<div name="non-full-conformance" hidden>
									<p>
									As não conformidades e/ou isenções são indicadas abaixo.
									</p>
									<h3 class="label">Conteúdo não acessível</h3>
									<p>
									A. Enumeração de quais são
									<strong>as secções/conteúdos/funções</strong>
									<span class="entity-target-website">do sítio Web</span>
									<span class="entity-target-app" hidden>da aplicação móvel</span>
									que não são ainda acessíveis:
									</p>

									<fieldset class="group naoacessivel">
										<legend class="visuallyhidden">
											Secções, Counteúdos e Funções
										</legend>
										<div class="field line">
											<label for="accstmnt_non_conformance_sections_1">Secção/Conteúdo/Função 1</label>
											<input type="text" class="form80" id="accstmnt_non_conformance_sections_1" name="accstmnt_non_conformance_sections"/>
										</div>
										<div class="field proto">
											<label for="accstmnt_non_conformance_sections_[n]">Secção/Conteúdo/Função [n]</label>
											<input type="text" class="form80" id="accstmnt_non_conformance_sections_[n]" name="accstmnt_non_conformance_sections"/>
											<button type="button" class="remove-line">
												Remover secção/conteúdo/função
											</button>
										</div>

										<button type="button" class="add-line" id="accstmnt_non_conformance_sections_button" >
											Adicionar nova secção/conteúdo/função
										</button>
									</fieldset>

									<p>
									B. <strong>Razões</strong> (se aplicável) porque o
									conteúdo indicado acima não é acessível: (por exemplo,
									a) não conformidade com o Decreto-Lei n.º 83/2018, b) está fora
									do âmbito do Decreto-Lei n.º 83/2018, ou embora dentro do âmbito
									está momentaneamente inacessível devido a c) encargos
									desproporcionados, em relação aos quais foi invocada
									exceção temporária no âmbito do artigo 6.º do Decreto-Lei n.º
									83/2018 e artigo 5.º da Diretiva (UE) 2016/2102.
									</p>

									<fieldset class="group naoacessivel">
										<legend class="visuallyhidden">Razões</legend>
										<div class="field line">
											<label for="accstmnt_non_conformance_reasons_1">Razão 1</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_reasons_1" name="accstmnt_non_conformance_reasons"/>
										</div>
										<div class="field proto">
											<label for="accstmnt_non_conformance_reasons_[n]">Razão [n]</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_reasons_[n]" name="accstmnt_non_conformance_reasons"/>
											<button type="button" class="remove-line">
												Remover razão
											</button>
										</div>

										<button type="button" class="add-line" id="accstmnt_non_conformance_reasons_button">
											Adicionar nova razão
										</button>
									</fieldset>

									<p>
										C. <strong>Alternativas acessíveis</strong> aos constrangimentos mencionados em A. e B. da presente secção (sempre que apropriado):
									</p>

									<fieldset class="group naoacessivel">
										<legend class="visuallyhidden">
											Alternativas acessíveis
										</legend>
										<div class="field line">
											<label for="accstmnt_non_conformance_alternatives_1">Alternativa acessível 1</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_alternatives_1" name="accstmnt_non_conformance_alternatives"/>
										</div>
										<div class="field proto">
											<label for="accstmnt_non_conformance_alternatives_[n]">Alternativa acessível [n]</label>
											<input class="form80" type="text" id="accstmnt_non_conformance_alternatives_[n]" name="accstmnt_non_conformance_alternatives"/>
											<button type="button" class="remove-line">
												Remover alternativa acessível
											</button>
										</div>

										<button type="button" class="add-line" id="accstmnt_non_conformance_alternatives_button">
											Adicionar nova alternativa acessível
										</button>
									</fieldset>
								</div>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
									<div class="button-group statement-actions">
										<a class="button btn_tutorial btn_tutorial_gray" href="#create-basic" role="button" aria-controls="passo1-tab">
											<span aria-label="página anterior" role="img" class="icon-arrow-bullets-left"></span>
											Passo 1
										</a>
									</div>
								</div>
								<div class="col-sm-6 next-page">
									<div class="button-group statement-actions">
										<a class="button btn_tutorial btn_tutorial" href="#create-technical" role="button" aria-controls="passo3-tab">
											Passo 3
											<span aria-label="página seguinte" role="img" class="icon-arrow-bullets"></span>
										</a>
									</div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="passo3-tab" aria-labelledby="create-technical" hidden="" class="tab-passos">
							
							<h3 id="create-technical">Passo 3</h3>
							<h2>Elaboração da Declaração</h2>

							<div>
								<p>
									Esta declaração foi atualizada a
									<input type="date" id="accstmt_date" class="form40 today" title="Introduza a data de criação ou de atualização da Declaração"/>.
								</p>

								<p>
								  De acordo com o artigo 9º do Decreto-Lei L n.º 83/2018, as entidades
								  devem adotar os procedimentos de monitorização a seguir
								  apresentados. Os procedimentos A) e B) são obrigatórios. O
								  procedimento C) é recomendado.
								</p>

								<hr aria-hidden="true" />

								<h3>
								  A. Avaliação automática<br /><small>(Preenchimento obrigatório)</small>
								</h3>

								<p>
								  De acordo com a alínea a) do n.º 1 do artigo 9º do
								  Decreto-Lei n.º 83/2018, este tipo de análise é obrigatória
								  e deve ser realizada de acordo com determinadas condições.
								</p>

								<!--<p>
											Efetuou algum tipo de avaliação usando para o efeito
											ferramentas automáticas/semi-automáticas?
								</p>-->

								<fieldset>
									<legend>
									Efetuou algum tipo de avaliação usando para o efeito
									ferramentas automáticas/semi-automáticas?
									</legend>
									<select class="form40" id="accstmnt_tools">
										<option value="[_______________]" disabled="disabled" selected="selected">seleccionar opção</option>
										<option value="yes">Sim</option>
										<option value="no">Não</option>
									</select>
								</fieldset>

								<div name="with_tools" hidden>
									<p>
									Se levou a efeito avaliações automáticas, inclua a data
									da sua realização, o nome da ou das ferramentas
									utilizadas, a amostra ou as amostras de páginas
									utilizadas, os resultados alcançados e as hiperligações
									para a documentação da ou das análises realizadas.
									</p>

									<fieldset id="accstmnt_assessment_with_tools" class="group">
										<div class="field line">
											<p>
												<b>Avaliação automática 1</b>
											</p>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_data_1">Data da avaliação</label>
												<input
												  class="form40"
												  type="date"
												  id="accstmnt_assessment_with_tools_data_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_title_1">Título do relatório</label>
												<input
												  class="form100"
												  type="text"
												  id="accstmnt_assessment_with_tools_title_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_address_1">Endereço Web do relatório</label>
												<input
												  class="form100"
												  type="url"
												  id="accstmnt_assessment_with_tools_address_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_tool_1">Ferramenta</label>
												<input
												  class="form60"
												  type="text"
												  id="accstmnt_assessment_with_tools_tool_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_pages_1">Número de páginas</label>
												<input
												  class="form10"
												  type="number"
												  id="accstmnt_assessment_with_tools_pages_1"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_report_1">Síntese de resultados</label>
												<textarea
												  class="form100"
												  id="accstmnt_assessment_with_tools_report_1"
												  name="accstmnt_assessment_with_tools_data"
												  rows="3"
												  required
												  placeholder="(Exemplo) No total das 86 páginas foi obtido um score de 9.6 na escala do AccessMonitor (1-10) tendo-se obtido os seguintes níveis de conformidade 75% das páginas passam a bateria de testes para o nível A, 50% passam os testes para o AA e 25% os testes para o AAA. 25% não passam na bateria de testes."
												></textarea>
											</div>
										</div>

										<div class="field proto extra">
											<p>
												<b>Avaliação automática [n] </b>
											</p>
											<div class="field">
											<label for="accstmnt_assessment_with_tools_data_[n]">Data da avaliação</label>
											<input
												class="form40"
												type="date"
												id="accstmnt_assessment_with_tools_data_[n]"
												name="accstmnt_assessment_with_tools_data"
												required
											/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_title_[n]">Título do relatório</label>
												<input
												  class="form100"
												  type="text"
												  id="accstmnt_assessment_with_tools_title_[n]"
												  name="accstmnt_assessment_with_tools_data"
												  required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_address_[n]">Endereço Web do relatório</label>
												<input
													class="form100"
													type="url"
													id="accstmnt_assessment_with_tools_address_[n]"
													name="accstmnt_assessment_with_tools_data"
													required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_tool_[n]">Ferramenta</label>
												<input
													class="form60"
													type="text"
													id="accstmnt_assessment_with_tools_tool_[n]"
													name="accstmnt_assessment_with_tools_data"
													required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_pages_[n]">Número de páginas</label>
												<input
													class="form10"
													type="number"
													id="accstmnt_assessment_with_tools_pages_[n]"
													name="accstmnt_assessment_with_tools_data"
													required
												/>
											</div>
											<div class="field">
												<label for="accstmnt_assessment_with_tools_report_[n]">Síntese de resultados</label>
												<textarea
													class="form100"
													id="accstmnt_assessment_with_tools_report_[n]"
													name="accstmnt_assessment_with_tools_data"
													rows="3"
													required
												></textarea>
											</div>
											<button type="button" class="remove-line">
												Remover avaliação automática
											</button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="accstmnt_assessment_with_tools_button"
										>
										  Adicionar outra avaliação automática
										</button>
									</fieldset>
								</div>

								<div name="without_tools" hidden>
									<p>
									Se não levou a efeito qualquer avaliação automática,
									explicite as razões para não o ter feito:
									</p>

									<fieldset id="accstmnt_assessment_without_tools" class="group">
										<div class="field line">
											<label for="accstmnt_assessment_without_tools_1"><b>Razão 1</b></label>
											<input
												class="form100"
												type="text"
												id="accstmnt_assessment_without_tools_1"
												name="accstmnt_assessment_without_tools"
											/>
										</div>

										<div class="field proto">
											<label for="accstmnt_assessment_without_tools_[n]"><b>Razão [n]</b></label>
											<input
												class="form100"
												type="text"
												id="accstmnt_assessment_without_tools_[n]"
												name="accstmnt_assessment_without_tools"
											/>
											<button type="button" class="remove-line">
												Remover razão
											</button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="accstmnt_assessment_without_tools_button"
										>
										  Adicionar outra razão
										</button>
									</fieldset>
								</div>

								<hr aria-hidden="true" />

								<h3>
									B. Avaliação manual feita com base em lista de verificação
								</h3>
								<p>
									De acordo com a alínea b) do n.º 1 do artigo 9º do Decreto-Lei n.º 83/2018 este tipo de análise é obrigatória e deve ser efetuada de acordo com determinadas condições.
								</p>

								<fieldset>
									<legend>
										Efetuou algum tipo de avaliação manual com base nas
										<a href="https://amagovpt.github.io/kit-selo/checklists/" target="_blank">Listas de verificação (disponíveis no GitHub da ARTE; abre numa nova janela)</a>?
									</legend>
									<select class="form40" id="accstmnt_manual">
										<option value="[_______________]" disabled="disabled" selected="selected">seleccionar opção</option>
										<option value="yes">Sim</option>
										<option value="no">Não</option>
									</select>
								</fieldset>

								<div name="with_manual" hidden>
									<p>
									Se levou a efeito uma avaliação manual de acordo com a
									lista de verificação referenciada em
									<a
									  href="https://amagovpt.github.io/kit-selo/checklists/checklist-10aspetos.html"
									  >10 aspetos críticos de acessibilidade funcional</a
									>, inclua o resultado (do total das heurísticas
									aplicáveis, quantas é que são satisfeitas) e uma
									hiperligação para o relatório de suporte da respetiva
									análise. 
									<br>
									Se levou a efeito outras avaliações manuais,
									faça menção aos melhores resultados alcançados e forneça
									uma hiperligação para o respetivo relatório de suporte à
									análise.
									</p>

									<fieldset
									id="accstmnt_assessment_with_manual"
									class="group"
									>
										<div class="field line">
										  <p>
											<b>Avaliação manual 1</b><br /><small
											  >(Todos os campos são de preenchimento
											  obrigatório)</small
											>
										  </p>
										  <div class="field">
											<label for="accstmnt_assessment_with_manual_data_1"
											  >Data da avaliação</label
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
											  >Título do relatório de suporte</label
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
											  >Endereço Web do relatório de suporte</label
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
											  >Amostra utilizada na avaliação manual (número de
											  páginas)</label
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
											  >Da lista de verificação quantas heurísticas são
											  satisfeitas?</label
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
											  >Da lista de verificação quantas heurísticas são
											  aplicáveis?</label
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
											<b>Avaliação manual [n]</b><br /><small
											  >(Todos os campos são de preenchimento
											  obrigatório)</small
											>
										  </p>
										  <div class="field">
											<label
											  for="accstmnt_assessment_with_manual_data_[n]"
											  >Data da avaliação</label
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
											  >Título do relatório de suporte</label
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
										      class="form100"
											  for="accstmnt_assessment_with_manual_address_[n]"
											  >Endereço Web do relatório de suporte</label
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
											  >Amostra utilizada na avaliação manual (número de
											  páginas)</label
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
											  >Da lista de verificação quantas heurísticas são
											  satisfeitas?</label
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
											  >Da lista de verificação quantas heurísticas são
											  aplicáveis?</label
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
											Remover avaliação manual
										  </button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="accstmnt_assessment_with_manual_button"
										>
										  Adicionar outra avaliação manual
										</button>
									</fieldset>
								</div>

								<div name="without_manual" hidden>
									<p>
									Se não levou a efeito nenhuma avaliação manual, explique
									a razão ou razões para não o ter feito:
									</p>

									<fieldset
									id="accstmnt_assessment_without_manual"
									class="group"
									>
										<div class="field line">
										  <label for="accstmnt_assessment_without_manual_1"
											><b>Razão 1</b></label
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
											><b>Razão [n]</b></label
										  >
										  <input
										    class="form100"
											type="text"
											id="accstmnt_assessment_without_manual_[n]"
											name="accstmnt_assessment_without_manual"
										  />
										  <button type="button" class="remove-line">
											Remover razão
										  </button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="ccstmnt_assessment_without_manual_button"
										>
										  Adicionar outra razão
										</button>
									</fieldset>
								</div>

								<hr aria-hidden="true" />

								<h3>C. Testes de usabilidade com pessoas com deficiência:</h3>
								<p>
								  De acordo com a alínea c) do n.º 1 do artigo 9º do
								  Decreto-Lei n.º 83/2018, este tipo de análise é
								  recomendada.
								</p>

								<fieldset>
									<legend>
										Efetuou algum tipo de testes com utilizadores?
									</legend>
									<select class="form40" id="accstmnt_users">
										<option value="[_______________]" disabled="disabled" selected="selected">seleccionar opção</option>
										<option value="yes">Sim</option>
										<option value="no">Não</option>
									</select>
								</fieldset>

								<div name="with_users" hidden>
									<p>
									Se efetuou testes de usabilidade com pessoas com
									deficiência, liste-os abaixo, enunciando as tarefas, os
									participantes, um sumário das principais conclusões e
									uma hiperligação para o relatório do estudo.
									</p>

									<fieldset
									id="accstmnt_assessment_with_users"
									class="group"
									>
										<div class="field line">
										  <p>
											<label for="accstmnt_assessment_with_users_1"
											  ><b>Avaliação com utilizadores 1</b><br /><small
												>(Todos os campos são de preenchimento
												obrigatório)</small
											  ></label
											>
										  </p>
										  <div class="field">
											<label for="accstmnt_assessment_with_users_data_1"
											  >Data da avaliação</label
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
											  >Título do relatório do estudo</label
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
											  >URL do relatório do estudo</label
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
											  >Participantes</label
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
											  >Tarefas/Processo</label
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
											  >Principais resultados (sumário):</label
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
											  ><b>Avaliação com utilizadores [n]</b><br /><small
												>(Todos os campos são de preenchimento
												obrigatório)</small
											  ></label
											>
										  </p>
										  <div class="field">
											<label for="accstmnt_assessment_with_users_data_[n]"
											  >Data da avaliação</label
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
											  >Título do relatório do estudo</label
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
											  >URL do relatório do estudo</label
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
											  >Participantes</label
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
											  >Tarefas/Processo</label
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
											  >Principais resultados (sumário):</label
											>
											<textarea
										      class="form100"
											  id="accstmnt_assessment_with_users_results_[n]"
											  name="accstmnt_assessment_with_users_data"
											  required
											></textarea>
										  </div>
										  <button type="button" class="remove-line">
											Remover avaliação com utilizadores
										  </button>
										</div>

										<button
										  type="button"
										  class="add-line"
										  id="accstmnt_assessment_with_users_button"
										>
										  Adicionar outra avaliação com utilizadores
										</button>
									</fieldset>
								</div>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-state" role="button" aria-controls="passo2-tab">
									  <span aria-label="página anterior" role="img" class="icon-arrow-bullets-left"></span>
									  Passo 2
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#create-contact" role="button" aria-controls="passo4-tab">
									  Passo 4
									  <span aria-label="página seguinte" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="passo4-tab" aria-labelledby="create-contact" hidden="" class="tab-passos">
							
							<h3 id="create-contact">Passo 4</h3>
							<h2>
							  Contacto e solicitação de informação relativa
							  <span class="entity-target-website">ao sítio Web</span>
							  <span class="entity-target-app" hidden>à aplicação móvel</span>
							</h2>
							
							<div>
								<p>
								  Caso pretenda contactar
								  <span class="entity_article">a</span>
								  <span class="entity_description">entidade</span>
								  por causa
								  <span class="entity-target-website">do</span>
								  <span class="entity-target-app" hidden>da</span>
								  presente
								  <span class="entity-target-website">sítio Web</span>
								  <span class="entity-target-app" hidden
									>aplicação Web</span
								  >,
								  para apresentar sugestões ou dar conta de alguma
								  dificuldade relacionada com questões de acessibilidade a
								  algum documento, página ou serviço disponibilizado,
								  por favor, use um dos seguintes contactos:
								</p>

								<fieldset class="group">
									<div class="field line">
										<label for="accstmnt_orginfo_contact_1"
										  ><b>Contacto 1</b></label
										>
										<div class="field">
										  <label for="accstmnt_orginfo_contacts_1"
											>Rótulo do tipo de contacto (p.e. “Correio
											eletrónico:”; “Telefone:”; “Morada:”; …)</label
										  >
										  <input
										    class="form60"
											type="text"
											id="accstmnt_orginfo_contacts_1"
											name="accstmnt_orginfo_contacts"
										  />
										</div>
										<div class="field">
										  <label for="accstmnt_orginfo_element_1"
											>Contacto</label
										  >
										  <input
										    class="form60"
											type="text"
											id="accstmnt_orginfo_element_1"
											name="accstmnt_orginfo_contacts"
										  />
										</div>
									</div>
									<div class="field proto extra">
										<p>
										  <label for="accstmnt_orginfo_contact_[n]"
											><b>Contacto [n]</b></label
										  >
										</p>
										<div class="field">
										  <label for="accstmnt_orginfo_contacts_[n]"
											>Rótulo do tipo de contacto (p.e. “Correio
											eletrónico:”; “Telefone:”; “Morada:”; …)</label
										  >
										  <input
										    class="form60"
											type="text"
											id="accstmnt_orginfo_contacts_[n]"
											name="accstmnt_orginfo_contacts"
										  />
										</div>
										<div class="field">
										  <label for="accstmnt_orginfo_element_[n]"
											>Contacto</label
										  >
										  <input
										    class="form60"
											type="text"
											id="accstmnt_orginfo_element_[n]"
											name="accstmnt_orginfo_contacts"
										  />
										</div>
										<button type="button" class="remove-line">
										  Remover contacto
										</button>
									</div>

									<button
									type="button"
									class="add-line"
									id="accstmnt_orginfo_button"
									>
										Adicionar contacto
									</button>
								</fieldset>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-technical" role="button" aria-controls="passo3-tab">
									  <span aria-label="página anterior" role="img" class="icon-arrow-bullets-left"></span>
									  Passo 3
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#create-seal" role="button" aria-controls="passo5-tab">
									  Passo 5
									  <span aria-label="página seguinte" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="passo5-tab" aria-labelledby="create-seal" hidden="" class="tab-passos">
							
							<h3 id="create-seal">Passo 5</h3>
							<h2>
							  Outras evidências<!-- / esforços para tornar os conteúdos
										mais acessíveis e mais usáveis-->
							</h2>
							
							<div>
								<fieldset class="group">
								  <div class="field" id="seal-awarded">
									<legend class="label">
									  É detentor de um Selo de Usabilidade e Acessibilidade?
									</legend>
									<div class="radio-field">
									  <input
										type="radio"
										name="entity-seal"
										id="entity-seal-no"
										checked="checked"
										value="no"
									  />
									  <label for="entity-seal-no">Não</label>
									</div>
									<div class="radio-field">
									  <input
										type="radio"
										name="entity-seal"
										id="entity-seal-bronze"
										value="Bronze"
									  />
									  <label for="entity-seal-bronze">Bronze</label>
									</div>

									<div class="radio-field">
									  <input
										type="radio"
										name="entity-seal"
										id="entity-seal-prata"
										value="Prata"
									  />
									  <label for="entity-seal-prata">Prata</label>
									</div>

									<div class="radio-field">
									  <input
										type="radio"
										name="entity-seal"
										id="entity-seal-ouro"
										value="Ouro"
									  />
									  <label for="entity-seal-ouro">Ouro</label>
									</div>
								  </div>
								</fieldset>

								<br />
									
								<div class="group">
								  <div class="field">
									<label
									  for="accstmnt_assessment_additional_evidence_data"
									  >Adicionar outra evidência</label
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
									  <span aria-label="página anterior" role="img" class="icon-arrow-bullets-left"></span>
									  Passo 4
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#create-closing" role="button" aria-controls="passo6-tab">
									  Passo 6
									  <span aria-label="página seguinte" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="passo6-tab" aria-labelledby="create-closing" hidden="" class="tab-passos">
							
							<h3 id="create-closing">Passo 6</h3>
							<h2>
							  Denúncia de situações de discriminação
							</h2>
							
							<div>
								<div class="group">
								  <p>
									De acordo com o n.º 1 do artigo 13.º do Decreto-Lei n.º 83/2018,
									de 19 de outubro, sempre que uma pessoa com deficiência
									seja objeto de um tratamento menos favorável do que
									aquele que é, tenha sido ou venha a ser dado a outra
									pessoa em situação comparável, que consubstancie uma
									prática discriminatória contra pessoas com deficiência,
									prevista e punida nos termos do
									<a
									  href="http://data.dre.pt/eli/lei/46/2006/08/28/p/dre/pt/html"
									  >artigo 4.º da Lei n.º 46/2006, de 28 de agosto</a
									>, pode, essa pessoa, apresentar queixa, de acordo com o
									disposto no
									<a
									  href="https://data.dre.pt/eli/dec-lei/34/2007/02/15/p/dre/pt/html"
									  >Decreto-Lei n.º 34/2007, de 15 de fevereiro</a
									>.
								  </p>
								  <p>
									O Instituto Nacional para a Reabilitação, IP (INR),
									disponibiliza um
									<a
									  href="http://www.inr.pt/resultados-de-pesquisa/-/journal_content/56/11309/45065?p_p_auth=wje2GjQi"
									  >formulário para denunciar situações de
									  discriminação</a
									>, encaminhando as queixas apresentadas às entidades
									competentes. Anualmente, o INR elabora um
									relatório anual sobre a aplicação da lei que proíbe e
									pune a discriminação em razão da deficiência e da
									existência de risco agravado de saúde (Lei n.º 46/2006,
									de 28 de agosto).
								  </p>
								</div>
							</div>

							<hr aria-hidden="true" />
							
							<div class="row g-0">
								<div class="col-sm-6 previous-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial_gray" href="#create-seal" role="button" aria-controls="passo5-tab">
									  <span aria-label="página anterior" role="img" class="icon-arrow-bullets-left"></span>
									  Passo 5
									</a>
								  </div>
								</div>
								<div class="col-sm-6 next-page">
								  <div class="button-group statement-actions">
									<a class="button btn_tutorial btn_tutorial" href="#preview" role="button" aria-controls="previsualizar-tab">
									  Pré-visualizar
									  <span aria-label="página seguinte" role="img" class="icon-arrow-bullets"></span>
									</a>
								  </div>
								</div>
							</div>
							
						</div>

						<div tabindex="0" role="tabpanel" id="previsualizar-tab" aria-labelledby="preview" hidden="" class="tab-passos">
							
							<h3 id="preview">Pré-visualizar</h3>
							<h2>
							  Pré-visualização e opção para descarregar a Declaração 
							</h2>
							
							<div>
								<div class="group">
									<p>Verifique se a informação abaixo está como pretende. Pode ainda voltar a cada um dos passos e editar os respetivos campos.</p>
									<p>Se considera que todos os dados estão corretos pode descarregar o ficheiro em HTML. Ao copiar o seu conteúdo para a página onde pretende publicar a Declaração, esta irá ficar com o estilo do seu sítio Web.</p>
									<p>Se preferir sair desta página e finalizar o preenchimento da Declaração mais tarde, descarregue também o ficheiro para o seu computador e, quando quiser, pode carregá-lo na página inicial deste Gerador e retomar a edição da Declaração.</p>
								</div>
									
						
								<!--section class="page preview" hidden="hidden">
									<aside class="box box-example">
										<header class="box-h box-h-example">
											Visualização da sua declaração de acessibilidade
										</header-->

								<div class="box-i discard">
									<div id="statement_generated">
										<div id="statement_header">
											<h1>Declaração de Acessibilidade e Usabilidade</h1>
											<p>
												<span class="mr mr-e-intro"><span data-print="entity-gender"></span></span>
												<span class="mr mr-e-name"><span data-print="entity-name"></span></span>
												compromete-se a disponibilizar
												<span class="mr mr-t-type"><span class="target-type">[_______________]</span></span>
												<a href="#" class="siteurl"><span class="mr mr-t-desc"><span class="target-name">[_______________]</span></span></a>, 
												em conformidade com o Decreto-Lei n.º 83/2018, de 19 de
												outubro, que transpõe a Diretiva (UE) 2016/2102 do
												Parlamento Europeu e do Conselho, relativa à
												acessibilidade dos sítios Web e das aplicações móveis.
											</p>
										</div>

										<div id="statement-create-state">
											<h2 id="n1">I. Estado de conformidade</h2>
											<div id="conformance-status-full">
												<p class="capFL">
													<span class="target-type">[_______________]</span>
													<a href="#" class="siteurl"><span class="target-name">[_______________]</span></a>
													d<span
													  data-print="entity-gender"
													  data-printfilter="lowerfirst"
													  class="lowFL"
													></span>
													<span data-print="entity-name"></span> está
													<span class="mr mr-conformance-status"
													  ><span class="conformance-output"
														>[_______________]</span
													  ></span
													>
													para com o Decreto-Lei n.º 83/2018 de 19 de outubro.
												</p>
											</div>

											<div id="conformance-status-non-conformance" data-if="accstmnt_non_conformance_sections">
												<p>
													As não conformidades e/ou isenções são indicadas abaixo.
												</p>
												<h3>Não conformidades e/ou alvo de isenções</h3>
												<p>
												A. Enumeração
												<strong>das secções / conteúdos / funções</strong>
												d<span class="target-type">o sítio Web</span>
												que não estão conformes e/ou alvo de isenção:
												</p>
												<ul id="non-conformance-sections" class="mr mr-nonconf-sections" data-print="accstmnt_non_conformance_sections" data-printfilter="capitalize">
												</ul>
												<div id="conformance-status-non-conformance-reasons" data-if="accstmnt_non_conformance_reasons">
													<p>
														B. <strong>Razões</strong> que estão na base da não conformidade dos conteúdos indicados acima:
													</p>
													<ul
													  id="non-conformance-reasons"
													  class="mr mr-nonconf-reasons"
													  data-print="accstmnt_non_conformance_reasons"
													></ul>
												</div>
												<div id="conformance-status-non-conformance-alternatives" data-if="accstmnt_non_conformance_alternatives">
													<p>
													  C. <strong>Alternativas acessíveis</strong> aos
													  constrangimentos mencionados na presente secção:
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
											  II. Elaboração da presente declaração de acessibilidade e
											  usabilidade
											</h2>
											<p>
											  Esta declaração foi atualizada a
											  <span class="mr mr-date"
												><span
												  data-print="accstmt_date"
												  data-printdefault="DATE"
												>[_______________]</span></span
											  >.
											</p>

											<p>
											  De acordo com o artigo 9º do Decreto-Lei n.º 83/2018, as entidades
											  devem adotar os procedimentos de monitorização a seguir
											  apresentados. Os procedimentos A) e B) são obrigatórios. O
											  procedimento C) é recomendado.
											</p>

											<p>
											  <strong
												>A. Avaliações automáticas levadas a efeito</strong
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
												<p class="capFL"><span class="target-type">[_______________]</span> ainda não foi alvo de uma avaliação
												automática às práticas de acessibilidade.
												</p>
											</div>
											<div data-if="accstmnt_assessment_without_tools">
											  <p>
												Razões que levaram à não realização de avaliações
												automáticas:
											  </p>
											  <ul
												id="accstmnt_assessment_without_tools_list"
												class="mr mr-no-automatic-reasons"
												data-print="accstmnt_assessment_without_tools"
											  ></ul>
											</div>

											<p>
											  <strong>B. Avaliações manuais levadas a efeito:</strong>
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
												<span class="target-type">[_______________]</span> ainda não foi alvo de uma avaliação
												manual às práticas de acessibilidade.
											  </p>
											</div>
											<div data-if="accstmnt_assessment_without_manual">
											  <p>
												Razões que levaram à não realização de avaliações
												manuais:
											  </p>
											  <ul
												id="accstmnt_assessment_without_manual_list"
												class="mr mr-no-manual-reasons"
												data-print="accstmnt_assessment_without_manual"
											  ></ul>
											</div>

											<p>
												<strong
												>C. Testes de usabilidade com pessoas com
												deficiência:</strong
												>
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
											  <p class="capFL"><span class="target-type">[_______________]</span> ainda não foi alvo de testes com
												utilizadores com deficiência.
											  </p>
											</div>
										</div>

										<div id="statement-contact-block">
											<h2 id="n3">
											  III. Contacto e solicitação de informação relativa
											  <span class="target-type nType">[_______________]</span>
											</h2>
											<p>
											  Para contactar, enviar sugestões, efetuar reclamações ou
											  solicitar informação adicional relativamente aos conteúdos
											  e/ou funcionalidades presentes n<span class="target-type">[_______________]</span>
											  d<span
												data-print="entity-gender"
												data-printfilter="lowerfirst"
												class="lowFL"
											  ></span>
											  <span data-print="entity-name">[_______________]</span>, utilize, por
											  favor, os seguintes meios:
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
											  IV. Outras evidências<!-- / esforços para tornar os conteúdos
															mais acessíveis e mais usáveis-->
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
												
												  <span data-print="entity-gender"></span>
												  <span data-print="entity-name">[_______________]</span> não apresentou,
												  aquando do preenchimento da presente Declaração,
												  outras evidências ou esforços para tornar o seu sítio
												  Web conforme para com os requisitos de acessibilidade
												  constantes do Decreto-Lei n.º 83/2018, de 19 de outubro.
												
											  </span></p>
											</div>
											<div data-if="accstmnt_assessment_additional_evidence_data">
											  <h3>Outras evidências</h3>
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
											  V. Denúncia de situações de discriminação
											</h2>
											<p>
											  De acordo com o n.º 1 do artigo 13.º do Decreto-Lei n.º 83/2018, de
											  19 de outubro, sempre que uma pessoa com deficiência seja
											  objeto de um tratamento menos favorável do que aquele que
											  é, tenha sido ou venha a ser dado a outra pessoa em
											  situação comparável, que consubstancie uma prática
											  discriminatória contra pessoas com deficiência, prevista e
											  punida nos termos do
											  <a
												href="http://data.dre.pt/eli/lei/46/2006/08/28/p/dre/pt/html"
												>artigo 4.º da Lei n.º 46/2006, de 28 de agosto</a
											  >, pode, essa pessoa, apresentar queixa, de acordo com o
											  disposto no
											  <a
												href="https://data.dre.pt/eli/dec-lei/34/2007/02/15/p/dre/pt/html"
												>Decreto-Lei n.º 34/2007, de 15 de fevereiro</a
											  >.
											</p>
											<p>
											  O Instituto Nacional para a Reabilitação (INR, I.P.),
											  disponibiliza um
											  <a
												href="http://www.inr.pt/resultados-de-pesquisa/-/journal_content/56/11309/45065?p_p_auth=wje2GjQi"
												>formulário para denunciar situações de discriminação</a
											  >, encaminhando as queixas apresentadas às entidades
											  competentes. Anualmente, o INR, I.P. elabora um relatório
											  anual sobre a aplicação da lei que proíbe e pune a
											  discriminação em razão da deficiência e da existência de
											  risco agravado de saúde (Lei n.o 46/2006, de 28 de
											  agosto).
											</p>
										</div>

										<div id="statement-limitations-block"></div>

										<hr aria-hidden="true" />

										<p>
											A presente Declaração de Acessibilidade e Usabilidade foi
											criada com o auxílio do
											<a href="https://www.acessibilidade.gov.pt/gerador"
											  >Gerador WAI-Tools PT v1.5</a
											>, desenvolvido no âmbito do projeto
											<a href="https://w3.org/WAI/Tools">WAI-Tools</a>, de cujo
											consórcio a ARTE é parte integrante. A Declaração foi
											concebida em conformidade com o Decreto-Lei n.º 83/2018, de 19 de
											outubro.
										</p>
									</div>
								</div>
								
									<!--/aside-->
								
								<div class="box-i end">
									<div class="button-group-right statement-actions">
										<div class="nota instrucoes">
										<p><b>A sua Declaração está correta?</b><br>
										Se considera que sim ou pretende continuar depois, descarregue o ficheiro e guarde-o no seu computador. Se precisar de rever algo, utilize o menu lateral para aceder aos passos anteriores.</p>
										</div>
										
										<div class="button-group statement-actions">
										  <button type="button" data-action="preview_save_as_html" class="btn_tutorial">
											Descarregar ficheiro HTML
											<span aria-hidden="true" class="icon-arrow-download"></span>
										  </button>
										</div>
									</div>
									
								</div>
					
									<small>
										<b>Nota:</b><br>
										Ao pressionar o botão “Descarregar ficheiro HTML” vai guardar no seu computador um ficheiro que contém a estrutura da Declaração de Acessibilidade e Usabilidade.<br>
										<br>
										É muito importante que não altere a estrutura da informação HTML que lhe fornecemos aqui, porque encontra-se em formato <em lang="en">machine-readable</em> e será fundamental para que possamos localizar e considerar a sua Declaração. <br>
										<br>
										Se concluiu o preenchimento, copie o código e cole-o no corpo da página que vai apresentar a Declaração no seu sítio Web. O estilo (cores de letra, tamanhos, alinhamentos de texto,...) são os do seu sítio Web, que se encontram na(s) sua(s) folhas de estilo (CSS – <em lang="en">Cascading Style Sheets</em>).<br>
										<br>
										Se não finalizou o preenchimento e quer regressar mais tarde, use também o botão para guardar no seu computador uma versão em HTML do que já está preenchido. Com esse ficheiro, amanhã, ou sempre que quiser, poderá continuar no passo onde parou. Basta submetê-lo na primeira página deste Gerador, usando a opção “Carregar ficheiro”.<br>
									</small>						
								
					
							</div>

						</div>
						
						</form>
					  
					  
					 
					  
						

					</div>
					
				</section>
				
			</div>
		  
		</section>
