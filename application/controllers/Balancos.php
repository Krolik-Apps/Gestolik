<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Balancos extends CI_Controller {

		public function index()
		{
			$this->db->distinct();
			$this->db->select('data_abertura, data_fecho');
			$this->db->where('data_abertura <>', NULL);
			$this->db->where('data_fecho <>', NULL);
			$this->db->order_by('data_abertura', 'ASC');
			$fecho_de_contas["fecho_de_contas"] = $this->db->get('fecho_de_contas')->result_array();

			$this->load->view('template/header');
			$this->load->view('balancos', $fecho_de_contas);
            $this->load->view('template/footer');
		}

		public function balanco()
		{
			$this->db->from('despesas');
			$despesas["despesas"] = $this->db->get()->result_array();

			$this->db->from('receitas');
			$receitas["receitas"] = $this->db->get()->result_array();

			$this->db->from('balanco');
			$this->db->order_by('data', 'ASC');
			$balanco["balanco"] = $this->db->get()->result_array();

			$this->db->from('gestor');
			$gestor["gestor"] = $this->db->get()->result_array();

			$this->db->from('saldo');
			$saldo["saldo"] = $this->db->get()->result_array();

			$this->load->view('template/header');
			$this->load->view('balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
            $this->load->view('template/footer');
		}

		public function acrescentar_despesa()
		{
			//Vai buscar as datas da conta
			$this->db->from('gestor');
			$gestor = $this->db->get()->result_array();

			$this->db->from('gestor');
			$gestor["gestor"] = $this->db->get()->result_array();

			$this->db->from('saldo');
			$saldo["saldo"] = $this->db->get()->result_array();

			$alerta = [
				"tipo"          => "",
				"mensagem"      => ""
			];

			if($gestor[0]['conta_aberta'] == 0)
			{
				$this->load->view("template/header", $alerta);
				$this->load->view('abrir_balanco', array_merge($gestor, $saldo));
				$this->load->view('template/footer');
				$this->index();
				return;
			}

			$data = htmlspecialchars($this->input->post('data'));
			// $data_formatada = date("d-m-Y", strtotime($this->input->post('data_despesa')));
			$data_formatada = htmlspecialchars($this->input->post('data_despesa'));

			$dados = [
				"data" 						=> $data_formatada,
				"nome" 						=> htmlspecialchars($this->input->post('combo_despesa')),
				"tipo" 						=> "Débito",
				"valor"						=> htmlspecialchars($this->input->post('valor_despesa'))
			];

			if($dados['data'] == "")
			{
				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "A Data não pode ficar em branco.";
				
				$this->db->from('despesas');
				$despesas["despesas"] = $this->db->get()->result_array();

				$this->db->from('receitas');
				$receitas["receitas"] = $this->db->get()->result_array();

				$this->db->from('balanco');
				$this->db->order_by('data', 'ASC');
				$balanco["balanco"] = $this->db->get()->result_array();

				$this->db->from('gestor');
				$gestor["gestor"] = $this->db->get()->result_array();

				$this->db->from('saldo');
				$saldo["saldo"] = $this->db->get()->result_array();

				$this->load->view('template/header');
				$this->load->view('balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
				$this->load->view('template/footer');
				return;
			}

			if($dados['nome'] == "")
			{
				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "O Nome não pode ficar em branco.";
				
				$this->db->from('despesas');
				$despesas["despesas"] = $this->db->get()->result_array();

				$this->db->from('receitas');
				$receitas["receitas"] = $this->db->get()->result_array();

				$this->db->from('balanco');
				$balanco["balanco"] = $this->db->get()->result_array();

				$this->db->from('gestor');
				$gestor["gestor"] = $this->db->get()->result_array();

				$this->db->from('saldo');
				$saldo["saldo"] = $this->db->get()->result_array();

				$this->load->view('template/header');
				$this->load->view('balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
				$this->load->view('template/footer');
				return;
			}

			if($dados['valor'] == "")
			{
				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "O Valor não pode ficar em branco.";
				
				$this->db->from('despesas');
				$despesas["despesas"] = $this->db->get()->result_array();

				$this->db->from('receitas');
				$receitas["receitas"] = $this->db->get()->result_array();

				$this->db->from('balanco');
				$balanco["balanco"] = $this->db->get()->result_array();

				$this->db->from('gestor');
				$gestor["gestor"] = $this->db->get()->result_array();

				$this->db->from('saldo');
				$saldo["saldo"] = $this->db->get()->result_array();

				$this->load->view('template/header');
				$this->load->view('balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
				$this->load->view('template/footer');
				return;
			}

			$gravar_linha = $this->db->query('INSERT INTO balanco(data, nome, tipo, valor) VALUES(?,?,?,?)', $dados);

			$this->db->from('balanco');
			$this->db->order_by('id_balanco', 'DESC');
			$this->db->limit(1);
			$balanco = $this->db->get()->result_array();

			//Insere na tabela totalizadores
			$dados_totalizadores = [
				"id_despesa"			=> $balanco[0]['id_balanco'],
				"id_receita"			=> null,
				"data_abertura"			=> $gestor[0]["data_abertura"],
				"data"					=> $data_formatada,
				"nome"					=> htmlspecialchars($this->input->post('combo_despesa')),
				"valor"					=> $dados["valor"],
				"tipo"					=> "Débito"
			];

			$gravar_totalizador = $this->db->query('INSERT INTO totalizadores(id_despesa, id_receita, data_abertura, data, nome, valor, tipo) VALUES(?,?,?,?,?,?,?)', $dados_totalizadores);

			//Insere a nova linha nos totalizadores
			$this->db->from('gestor');
			$gestor = $this->db->get()->result_array();

			//Subtrai ao saldo
			$this->db->set('saldo', 'saldo - '.htmlspecialchars($this->input->post('valor_despesa')), FALSE);
			$this->db->update('saldo');

			$this->balanco();
		}

		public function acrescentar_receita()
		{
			//Vai buscar as datas da conta
			$this->db->from('gestor');
			$gestor = $this->db->get()->result_array();

			$this->db->from('gestor');
			$gestor["gestor"] = $this->db->get()->result_array();

			$this->db->from('saldo');
			$saldo["saldo"] = $this->db->get()->result_array();

			$alerta = [
				"tipo"          => "",
				"mensagem"      => ""
			];

			if($gestor[0]['conta_aberta'] == 0)
			{
				$this->load->view("template/header", $alerta);
				$this->load->view('abrir_balanco', array_merge($gestor, $saldo));
				$this->load->view('template/footer');
				$this->index();
				return;
			}

			$data = htmlspecialchars($this->input->post('data'));
			// $data_formatada = date("d-m-Y", strtotime($this->input->post('data_receita')));
			$data_formatada = htmlspecialchars($this->input->post('data_receita'));

			$dados = [
				"data" 						=> $data_formatada,
				"nome" 						=> htmlspecialchars($this->input->post('combo_receita')),
				"tipo" 						=> "Crédito",
				"valor"						=> htmlspecialchars($this->input->post('valor_receita'))
			];

			if($dados['data'] == "")
			{
				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "A Data não pode ficar em branco.";
				
				$this->db->from('despesas');
				$despesas["despesas"] = $this->db->get()->result_array();

				$this->db->from('receitas');
				$receitas["receitas"] = $this->db->get()->result_array();

				$this->db->from('balanco');
				$this->db->order_by('data', 'ASC');
				$balanco["balanco"] = $this->db->get()->result_array();

				$this->db->from('gestor');
				$gestor["gestor"] = $this->db->get()->result_array();

				$this->db->from('saldo');
				$saldo["saldo"] = $this->db->get()->result_array();

				$this->load->view('template/header');
				$this->load->view('balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
				$this->load->view('template/footer');
				return;
			}

			if($dados['nome'] == "")
			{
				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "O Nome não pode ficar em branco.";
				
				$this->db->from('despesas');
				$despesas["despesas"] = $this->db->get()->result_array();

				$this->db->from('receitas');
				$receitas["receitas"] = $this->db->get()->result_array();

				$this->db->from('balanco');
				$balanco["balanco"] = $this->db->get()->result_array();

				$this->db->from('gestor');
				$gestor["gestor"] = $this->db->get()->result_array();

				$this->db->from('saldo');
				$saldo["saldo"] = $this->db->get()->result_array();

				$this->load->view('template/header');
				$this->load->view('balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
				$this->load->view('template/footer');
				return;
			}

			if($dados['valor'] == "")
			{
				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "O Valor não pode ficar em branco.";
				
				$this->db->from('despesas');
				$despesas["despesas"] = $this->db->get()->result_array();

				$this->db->from('receitas');
				$receitas["receitas"] = $this->db->get()->result_array();

				$this->db->from('balanco');
				$balanco["balanco"] = $this->db->get()->result_array();

				$this->db->from('gestor');
				$gestor["gestor"] = $this->db->get()->result_array();

				$this->db->from('saldo');
				$saldo["saldo"] = $this->db->get()->result_array();

				$this->load->view('template/header');
				$this->load->view('balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
				$this->load->view('template/footer');
				return;
			}

			$gravar_linha = $this->db->query('INSERT INTO balanco(data, nome, tipo, valor) VALUES(?,?,?,?)', $dados);

			$this->db->from('balanco');
			$this->db->order_by('id_balanco', 'DESC');
			$this->db->limit(1);
			$balanco = $this->db->get()->result_array();

			//Insere na tabela totalizadores
			$dados_totalizadores = [
				"id_despesa"			=> null,
				"id_receita"			=> $balanco[0]['id_balanco'],
				"data_abertura"			=> $gestor[0]["data_abertura"],
				"data"					=> $data_formatada,
				"nome"					=> htmlspecialchars($this->input->post('combo_receita')),
				"valor"					=> $dados["valor"],
				"tipo"					=> "Crédito"
			];

			$gravar_totalizador = $this->db->query('INSERT INTO totalizadores(id_despesa, id_receita, data_abertura, data, nome, valor, tipo) VALUES(?,?,?,?,?,?,?)', $dados_totalizadores);

			//Insere a nova linha nos totalizadores
			$this->db->from('gestor');
			$gestor = $this->db->get()->result_array();

			//Soma ao saldo
			$this->db->set('saldo', 'saldo + '.htmlspecialchars($this->input->post('valor_receita')), FALSE);
			$this->db->update('saldo');

			$this->balanco();
		}

		public function acrescentar_despesa_editar()
		{
			// Vai buscar a data do balanço
			$data_abertura = htmlspecialchars($this->input->post('data_abertura'));
			$data_fecho = htmlspecialchars($this->input->post('data_fecho'));
			$data_registo = htmlspecialchars($this->input->post('data_despesa'));

			$dados = [
				"data_abertura" 						=> $data_abertura,
				"data" 									=> $data_registo,
				"data_fecho" 							=> $data_fecho,
				"nome"									=> htmlspecialchars($this->input->post('combo_despesa')),
				"valor_despesa"							=> htmlspecialchars($this->input->post('valor_despesa')),
				"valor_receita"							=> null,
				"tipo"									=> "Débito"
			]; 

			$alerta = [
				"tipo"          => "",
				"mensagem"      => ""
			];

			if($dados['valor_despesa'] == "")
			{
				$this->db->from('fecho_de_contas');
				$this->db->where('data_abertura', $data_abertura);
				$this->db->where('data_fecho', $data_fecho);
				$dados_fecho_de_conta["dados_fecho_de_conta"] = $this->db->get()->result_array();

				$this->db->distinct();
				$this->db->select('data_abertura, data_fecho');
				$this->db->where('data_abertura <>', NULL);
				$this->db->where('data_fecho <>', NULL);
				$fecho_de_contas["fecho_de_contas"] = $this->db->get('fecho_de_contas')->result_array();

				// Total Despesas
				$this->db->select_sum('valor_despesa');
				$this->db->where('data_abertura', $data_abertura);
				$this->db->where('data_fecho', $data_fecho);
				$total_despesas["total_despesas"] = $this->db->get('fecho_de_contas')->result_array();

				// Total Receitas
				$this->db->select_sum('valor_receita');
				$this->db->where('data_abertura', $data_abertura);
				$this->db->where('data_fecho', $data_fecho);
				$total_receitas["total_receitas"] = $this->db->get('fecho_de_contas')->result_array();

				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "O valor não pode ficar em branco.";

				$this->load->view('template/header', $alerta);
				$this->load->view('balancos', array_merge($dados_fecho_de_conta, $fecho_de_contas, $total_despesas, $total_receitas));
				$this->load->view('template/footer');
				return;
			}

			$gravar_linha = $this->db->query('INSERT INTO fecho_de_contas(data_abertura, data, data_fecho, nome, valor_despesa, valor_receita, tipo) VALUES(?,?,?,?,?,?,?)', $dados);

			redirect('balancos/editar?da='.$data_abertura.'&df='.$data_fecho, 'refresh');
		}

		public function acrescentar_receita_editar()
		{
			// Vai buscar a data do balanço
			$data_abertura = htmlspecialchars($this->input->post('data_abertura'));
			$data_fecho = htmlspecialchars($this->input->post('data_fecho'));
			$data_registo = htmlspecialchars($this->input->post('data_receita'));

			$dados = [
				"data_abertura" 						=> $data_abertura,
				"data" 									=> $data_registo,
				"data_fecho" 							=> $data_fecho,
				"nome"									=> htmlspecialchars($this->input->post('combo_receita')),
				"valor_despesa"							=> null,
				"valor_receita"							=> htmlspecialchars($this->input->post('valor_receita')),
				"tipo"									=> "Crédito"
			]; 

			$alerta = [
				"tipo"          => "",
				"mensagem"      => ""
			];

			if($dados['valor_receita'] == "")
			{
				$this->db->from('fecho_de_contas');
				$this->db->where('data_abertura', $data_abertura);
				$this->db->where('data_fecho', $data_fecho);
				$dados_fecho_de_conta["dados_fecho_de_conta"] = $this->db->get()->result_array();

				$this->db->distinct();
				$this->db->select('data_abertura, data_fecho');
				$this->db->where('data_abertura <>', NULL);
				$this->db->where('data_fecho <>', NULL);
				$fecho_de_contas["fecho_de_contas"] = $this->db->get('fecho_de_contas')->result_array();

				// Total Despesas
				$this->db->select_sum('valor_despesa');
				$this->db->where('data_abertura', $data_abertura);
				$this->db->where('data_fecho', $data_fecho);
				$total_despesas["total_despesas"] = $this->db->get('fecho_de_contas')->result_array();

				// Total Receitas
				$this->db->select_sum('valor_receita');
				$this->db->where('data_abertura', $data_abertura);
				$this->db->where('data_fecho', $data_fecho);
				$total_receitas["total_receitas"] = $this->db->get('fecho_de_contas')->result_array();

				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "O valor não pode ficar em branco.";

				$this->load->view('template/header', $alerta);
				$this->load->view('balancos', array_merge($dados_fecho_de_conta, $fecho_de_contas, $total_despesas, $total_receitas));
				$this->load->view('template/footer');
				return;
			}

			$gravar_linha = $this->db->query('INSERT INTO fecho_de_contas(data_abertura, data, data_fecho, nome, valor_despesa, valor_receita, tipo) VALUES(?,?,?,?,?,?,?)', $dados);

			redirect('balancos/editar?da='.$data_abertura.'&df='.$data_fecho, 'refresh');
		}

		public function apagar_linha()
		{
			$id_balanco = htmlspecialchars($_GET['id']);
			$data = $_GET['d'];
			$nome = $_GET['n'];
			$valor = $_GET['v'];

			$this->db->from('balanco');
			$this->db->where('id_balanco', $id_balanco);
			$valor_item = $this->db->get()->result_array();

			if($valor_item[0]['tipo'] == "Crédito")
			{
				$this->db->set('saldo', 'saldo - '.$valor, FALSE);
				$this->db->update('saldo');
			}
			else
			{
				$this->db->set('saldo', 'saldo + '.$valor, FALSE);
				$this->db->update('saldo');
			}

			$query_apagar = $this->db->query('DELETE FROM balanco WHERE id_balanco = ?', $id_balanco);

			$this->db->from('totalizadores');
			$linhas = $this->db->get()->result_array();

			if($linhas[0]["id_despesa"] == null){
				$query_apagar_totalizador = $this->db->query('DELETE FROM totalizadores WHERE id_despesa = ?', $linhas[0]["id_despesa"]);
			}
			else{
				$query_apagar_totalizador = $this->db->query('DELETE FROM totalizadores WHERE id_receita = ?', $linhas[0]["id_receita"]);
			}
			

			$this->balanco();
		}

		public function apagar_editar()
		{
			$id_fecho = [
				"id_fecho"		=>		htmlspecialchars($_GET['id'])
			];

			$data_abertura = htmlspecialchars($_GET['da']);
			$data_fecho = htmlspecialchars($_GET['df']);

			$query_apagar = $this->db->query('DELETE FROM fecho_de_contas WHERE id_fecho = ?', $id_fecho);

			redirect('balancos/editar?da='.$data_abertura.'&df='.$data_fecho, 'refresh');
		}

		public function fechar_conta()
		{
			//TABELA fecho_de_contas
			//data de abertura (Data de abertura da tabela 'gestor')
			//hora de fecho (Data atual)
			//nome da despesa (Adicionar o nome da despesa)
			//total da despesa (Soma do valor correspondente da despesa)
			//saldo total (subtrair a soma da despesa ao saldo da tabela 'saldo')
			$this->db->from('totalizadores');
			$totalizadores = $this->db->get()->result_array();

			date_default_timezone_set('Europe/London'); 
			// $data_fecho = date("d-m-Y", strtotime($this->input->post('data_fecho')));
			$data_fecho = htmlspecialchars($this->input->post('data_fecho'));

			$datas = [
				"data_abertura"			=> "",
				"data_fecho"			=> $data_fecho
			];

			$dados = [
				"data_abertura"			=> "",
				"data"					=> "",
				"data_fecho"			=> "",
				"nome"					=> "",
				"valor_despesa"			=> "",
				"valor_receita"			=> "",
				"tipo"					=> ""
			];

			foreach($totalizadores as $t)
			{
				$this->db->from('saldo');
				$saldo = $this->db->get()->result_array();

				if($t['tipo'] == "Crédito"){
					$dados = [
						"data_abertura"			=> $t['data_abertura'],
						"data"					=> $t['data'],
						"data_fecho"			=> $data_fecho,
						"nome"					=> $t['nome'],
						"valor_despesa"			=> null,
						"valor_receita"			=> $t['valor'],
						"tipo"					=> $t['tipo']
					];
				}
				else{
					$dados = [
						"data_abertura"			=> $t['data_abertura'],
						"data"					=> $t['data'],
						"data_fecho"			=> $data_fecho,
						"nome"					=> $t['nome'],
						"valor_despesa"			=> $t['valor'],
						"valor_receita"			=> null,
						"tipo"					=> $t['tipo'] 		
					];
				}
				

				$datas['data_abertura'] = $t['data_abertura'];

				// Se o total da despesa for maior que zero que insere a linha
				if($t['valor'] > 0)
				{
					$query = $this->db->query('INSERT INTO fecho_de_contas(data_abertura, data, data_fecho, nome, valor_despesa, valor_receita, tipo) VALUES(?,?,?,?,?,?,?)', $dados);
				}		
			}

			//TABELA TOTALIZADORES
			//deixar a tabela dos totalizadores apenas com o nome da despesa o resto deixar com valor nulo
			$query_apagar_balanco = $this->db->query('DELETE FROM totalizadores');

			//TABELA GESTOR
			//data de abertura a nulo
			//conta aberta a 0
			$this->db->set('data_abertura', NULL);
			$this->db->set('conta_aberta', 0);
			$this->db->update('gestor');

			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];

			$this->db->distinct();
			$this->db->select('data_abertura, data_fecho');
			$this->db->where('data_abertura <>', NULL);
			$this->db->where('data_fecho <>', NULL);
			$this->db->order_by('data_abertura', 'ASC');
			$fecho_de_contas["fecho_de_contas"] = $this->db->get('fecho_de_contas')->result_array();

			//TABELA balanco
			//limpar a tabela toda
			$query_apagar_balanco = $this->db->query('DELETE FROM balanco');

			$this->db->set('saldo', 0);
            $this->db->update('saldo');

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Fecho de contas feito com sucesso.";
			$this->load->view("template/header", $alerta);
			$this->load->view('balancos', $fecho_de_contas);
            $this->load->view('template/footer');
			return;
		}

		public function pesquisar()
		{
			$data_completa = explode(" / ", htmlspecialchars($this->input->post('combo_data_balanco')));
			$data_abertura = (isset($data_completa[0])) ? $data_completa[0] : redirect('balancos');
			$data_fecho = (isset($data_completa[1])) ? $data_completa[1] : redirect('balancos');

			$this->db->from('fecho_de_contas');
			$this->db->where('data_abertura', $data_abertura);
			$this->db->where('data_fecho', $data_fecho);
			$this->db->order_by('data', 'ASC');
			$dados_fecho_de_conta["dados_fecho_de_conta"] = $this->db->get()->result_array();

			$this->db->distinct();
			$this->db->select('data_abertura, data_fecho');
			$this->db->where('data_abertura <>', NULL);
			$this->db->where('data_fecho <>', NULL);
			$fecho_de_contas["fecho_de_contas"] = $this->db->get('fecho_de_contas')->result_array();

			// Total Despesas
			$this->db->select_sum('valor_despesa');
			$this->db->where('data_abertura', $data_abertura);
			$this->db->where('data_fecho', $data_fecho);
			$total_despesas["total_despesas"] = $this->db->get('fecho_de_contas')->result_array();

			// Total Receitas
			$this->db->select_sum('valor_receita');
			$this->db->where('data_abertura', $data_abertura);
			$this->db->where('data_fecho', $data_fecho);
			$total_receitas["total_receitas"] = $this->db->get('fecho_de_contas')->result_array();
			
			$this->load->view('template/header');
			$this->load->view('balancos', array_merge($dados_fecho_de_conta, $fecho_de_contas, $total_despesas, $total_receitas));
			$this->load->view('template/footer');
			return;
		}

		public function eliminar()
		{
			$datas = [
				"data_abertura"			=> htmlspecialchars($_GET['da']).'%',
				"data_fecho"			=> htmlspecialchars($_GET['df']).'%'
			];

			$query_apagar = $this->db->query('DELETE FROM fecho_de_contas WHERE data_abertura LIKE ? AND data_fecho LIKE ?', $datas);

			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];

			$this->db->distinct();
			$this->db->select('data_abertura, data_fecho');
			$this->db->where('data_abertura <>', NULL);
			$this->db->where('data_fecho <>', NULL);
			$fecho_de_contas["fecho_de_contas"] = $this->db->get('fecho_de_contas')->result_array();

			$this->db->set('data_abertura', NULL);
			$this->db->set('conta_aberta', 0);
            $this->db->update('gestor');

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Registo eliminado com sucesso.";
			$this->load->view("template/header", $alerta);
			$this->load->view('balancos', $fecho_de_contas);
            $this->load->view('template/footer');
			return;
		}

		public function editar()
		{
			// $data_abertura = $_GET['da'];
			// $data_fecho = $_GET['df'];

			// echo 'Data de Abertura: '.$data_abertura.'<br>Data de Fecho: '.$data_fecho;

			$data_abertura = explode('-', htmlspecialchars($_GET['da']));
			$ano_abertura = $data_abertura[0];
			$mes_abertura = $data_abertura[1];
			$dia_abertura = $data_abertura[2];

			$data_fecho = explode('-', htmlspecialchars($_GET['df']));
			$ano_fecho = $data_fecho[0];
			$mes_fecho = $data_fecho[1];
			$dia_fecho = $data_fecho[2];

			$this->db->from('despesas');
			$despesas["despesas"] = $this->db->get()->result_array();

			$this->db->from('receitas');
			$receitas["receitas"] = $this->db->get()->result_array();

			$this->db->from('fecho_de_contas');
			$this->db->where('data_abertura >=', htmlspecialchars($_GET['da']));
			$this->db->where('data_fecho <=', htmlspecialchars($_GET['df']));
			$fecho_de_contas["fecho_de_contas"] = $this->db->get()->result_array();		

			$this->db->from('gestor');
			$gestor["gestor"] = $this->db->get()->result_array();

			$this->db->from('saldo');
			$saldo["saldo"] = $this->db->get()->result_array();

			$this->load->view('template/header');
			$this->load->view('editar_balanco', array_merge($despesas, $receitas, $fecho_de_contas, $gestor, $saldo));
			$this->load->view('template/footer');
			return;
		}

		public function gravar_linha()
		{
			$id_fecho = htmlspecialchars($_GET['id']);
			$data_abertura = htmlspecialchars($_GET['da']);
			$data_fecho = htmlspecialchars($_GET['df']);
			$data = htmlspecialchars($_POST['data_item']); 
			$data_formatada = date("Y-m-d", strtotime($data));
			$nome = htmlspecialchars($_POST['nome_item']);
			$tipo = htmlspecialchars($_POST['tipo_item']);
			$valor = htmlspecialchars($_POST['valor_item']);
			
			if($tipo == "Débito")
			{
				$this->db->query("UPDATE fecho_de_contas SET data = '$data_formatada', nome = '$nome', valor_despesa = $valor, valor_receita = NULL, tipo = '$tipo' WHERE id_fecho = $id_fecho");
			}
			else if($tipo == "Crédito")
			{
				$this->db->query("UPDATE fecho_de_contas SET data = '$data_formatada', nome = '$nome', valor_despesa = NULL, valor_receita = '$valor', tipo = '$tipo' WHERE id_fecho = $id_fecho");
			}

			redirect('balancos/editar?da='.$data_abertura.'&df='.$data_fecho, 'refresh');
		}

		public function guardar_balanco()
		{
			$abertura_antiga = htmlspecialchars($_GET['da']);
			$fecho_antigo = htmlspecialchars($_GET['df']);
			$data_abertura = htmlspecialchars($this->input->post('data_abertura'));
			$data_fecho = htmlspecialchars($this->input->post('data_fecho'));

			$this->db->set('data_abertura', $data_abertura);
			$this->db->set('data_fecho', $data_fecho);
			$this->db->where('data_abertura', $abertura_antiga);
			$this->db->where('data_fecho', $fecho_antigo);
			$this->db->update('fecho_de_contas');
			
			// Carrega a página
			$this->db->from('fecho_de_contas');
			$this->db->where('data_abertura', $data_abertura);
			$this->db->where('data_fecho', $data_fecho);
			$dados_fecho_de_conta["dados_fecho_de_conta"] = $this->db->get()->result_array();

			$this->db->distinct();
			$this->db->select('data_abertura, data_fecho');
			$this->db->where('data_abertura <>', NULL);
			$this->db->where('data_fecho <>', NULL);
			$fecho_de_contas["fecho_de_contas"] = $this->db->get('fecho_de_contas')->result_array();

			// Total Despesas
			$this->db->select_sum('valor_despesa');
			$this->db->where('data_abertura', $data_abertura);
			$this->db->where('data_fecho', $data_fecho);
			$total_despesas["total_despesas"] = $this->db->get('fecho_de_contas')->result_array();

			// Total Receitas
			$this->db->select_sum('valor_receita');
			$this->db->where('data_abertura', $data_abertura);
			$this->db->where('data_fecho', $data_fecho);
			$total_receitas["total_receitas"] = $this->db->get('fecho_de_contas')->result_array();

			$this->load->view('template/header');
			$this->load->view('balancos', array_merge($dados_fecho_de_conta, $fecho_de_contas, $total_despesas, $total_receitas));
			$this->load->view('template/footer');
			return;
		}

		public function balanco_anual()
		{
			$this->load->view('template/header');
			$this->load->view('balanco_anual');
            $this->load->view('template/footer');
		}

		public function pesquisa_anual()
		{
			$ano = htmlspecialchars($this->input->post('combo_data_balanco_anual'));

			$ano_balanco['ano_balanco'] = $ano;

			// SOMA DESPESAS ======================================================================================================
			$this->db->select('nome');
			$this->db->select_sum('valor_despesa', 'valor_despesa');
			$this->db->like('data_abertura', $ano, 'after');
			$this->db->like('data_fecho', $ano, 'after');
			$this->db->where('tipo', 'Débito');
			$this->db->group_by('nome');
			$this->db->from('fecho_de_contas');
			$total_despesas = $this->db->get()->result_array();
			// ======================================================================================================

			// SOMA RECEITAS ======================================================================================================
			$this->db->select('nome');
			$this->db->select_sum('valor_receita', 'valor_receita');
			$this->db->like('data_abertura', $ano, 'after');
			$this->db->like('data_fecho', $ano, 'after');
			$this->db->where('tipo', 'Crédito');
			$this->db->group_by('nome');
			$this->db->from('fecho_de_contas');
			$total_receitas = $this->db->get()->result_array();
			// ======================================================================================================

			// Somar os valores todos
			$soma_total_depesas['soma_total_depesas'] = 0;
			$soma_total_receitas['soma_total_receitas'] = 0;

			foreach($total_despesas as $td)
			{
				$soma_total_depesas['soma_total_depesas'] += $td['valor_despesa'];
			}

			foreach($total_receitas as $tr)
			{
				$soma_total_receitas['soma_total_receitas'] += $tr['valor_receita'];
			}

			$this->db->select('nome');
			$this->db->select_sum('valor_despesa', 'valor_despesa');
			$this->db->like('data_abertura', $ano, 'after');
			$this->db->like('data_fecho', $ano, 'after');
			$this->db->where('tipo', 'Débito');
			$this->db->group_by('nome');
			$this->db->from('fecho_de_contas');
			$total_despesas["total_despesas"] = $this->db->get()->result_array();

			$this->db->select('nome');
			$this->db->select_sum('valor_receita', 'valor_receita');
			$this->db->like('data_abertura', $ano, 'after');
			$this->db->like('data_fecho', $ano, 'after');
			$this->db->where('tipo', 'Crédito');
			$this->db->group_by('nome');
			$this->db->from('fecho_de_contas');
			$total_receitas["total_receitas"] = $this->db->get()->result_array();

			$this->load->view('template/header', $ano_balanco);
			$this->load->view('balanco_anual', array_merge($total_despesas, $total_receitas, $soma_total_depesas, $soma_total_receitas));
			$this->load->view('template/footer');
		}
	}

?>