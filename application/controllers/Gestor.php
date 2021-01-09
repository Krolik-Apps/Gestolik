<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Gestor extends CI_Controller {

		public function saldo()
		{
			// Carregar Saldo
			$this->db->from('saldo');
			$gestor["gestor"] = $this->db->get()->result_array();

			$this->load->view('template/header');
			$this->load->view('saldo', $gestor);
            $this->load->view('template/footer');
		}

		public function alterar_saldo()
		{
			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];

			$valor_saldo = $this->input->post('valor_saldo');

			if($valor_saldo == "")
			{
				// Carregar Saldo
				$this->db->from('saldo');
				$gestor["gestor"] = $this->db->get()->result_array();

				$alerta['tipo'] = "erro";
				$alerta['mensagem'] = "O valor do saldo não pode estar vazio.";
				$this->load->view("template/header", $alerta);
				$this->load->view('saldo', $gestor);
				$this->load->view('template/footer');
				return;
			}

			$this->db->set('saldo', $valor_saldo);
            $this->db->update('saldo');

			// Carregar Saldo
			$this->db->from('saldo');
			$gestor["gestor"] = $this->db->get()->result_array();

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Saldo alterado com sucesso.";
			$this->load->view("template/header", $alerta);
			$this->load->view('saldo', $gestor);
            $this->load->view('template/footer');
			return;
		}

		public function criar()
		{
			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];
			
			$nome = $this->input->post("nome_despesa");

			if($nome == "")
			{
				// Carregar Despesas
				$this->db->from('despesas');
				$despesas["despesas"] = $this->db->get()->result_array();

				$alerta['tipo'] = "erro";
				$alerta['mensagem'] = "O Nome da Despesa não pode ficar em branco.";
				$this->load->view("template/header");
				$this->load->view("despesas", array_merge($alerta, $despesas));
				$this->load->view("template/footer");
				return;
			}

			// Carregar Despesas
			$this->db->from('despesas');
			$this->db->where('nome', $nome);
			$num_linhas = $this->db->get();

			if($num_linhas->num_rows() > 0)
			{
				// Carregar Despesas
				$this->db->from('despesas');
				$despesas["despesas"] = $this->db->get()->result_array();

				$alerta['tipo'] = "erro";
				$alerta['mensagem'] = "O nome '$nome' já existe na lista.";
				$this->load->view("template/header");
				$this->load->view("despesas", array_merge($alerta, $despesas));
				$this->load->view("template/footer");
				return;
			}

			$this->db->from('gestor');
			$gestor = $this->db->get()->result_array();

			$dados = [
				"nome" 				=> $nome
			];

			$query_criar = $this->db->query('INSERT INTO despesas(nome) VALUES(?)', $dados);
			//$query_criar2 = $this->db->query('INSERT INTO totalizadores(nome) VALUES(?)', $dados);

			// Carregar Despesas
			$this->db->from('despesas');
			$despesas["despesas"] = $this->db->get()->result_array();

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Despesa criada com sucesso.";
			$this->load->view("template/header");
			$this->load->view("despesas", array_merge($alerta, $despesas));
			$this->load->view("template/footer");
			return;
		}
		
		public function despesas()
		{
			// Carregar Despesas
			$this->db->from('despesas');
			$despesas["despesas"] = $this->db->get()->result_array();

			$this->load->view('template/header');
			$this->load->view('despesas', $despesas);
			$this->load->view('template/footer');	
		}

		// Apagar Despesa
		public function apagar_despesa()
		{
			$nome = $_GET['n'];

			$query_despesas = $this->db->query('DELETE FROM despesas WHERE nome = ?', $nome);

			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];

			// Carregar Despesas
			$this->db->from('despesas');
			$despesas["despesas"] = $this->db->get()->result_array();

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Despesa apagada com sucesso.";
			$this->load->view("template/header");
			$this->load->view("despesas", array_merge($alerta, $despesas));
			$this->load->view("template/footer");
			return;
		}

		// Apagar Despesa
		public function apagar_receita()
		{
			$nome = $_GET['n'];

			$query_receitas = $this->db->query('DELETE FROM receitas WHERE nome = ?', $nome);

			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];

			// Carregar Despesas
			$this->db->from('receitas');
			$receitas["receitas"] = $this->db->get()->result_array();

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Receita apagada com sucesso.";
			$this->load->view("template/header");
			$this->load->view("receitas", array_merge($alerta, $receitas));
			$this->load->view("template/footer");
			return;
		}

		public function editar()
		{
			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];

			$nome_antigo = $_GET['n'];

			$this->db->set('nome', $this->input->post('nome_despesa'));
            $this->db->where('nome', $nome_antigo);
			$this->db->update('despesas');
			
			$this->db->set('nome', $this->input->post('nome_despesa'));
            $this->db->where('nome', $nome_antigo);
			$this->db->update('balanco');

			$this->db->set('nome', $this->input->post('nome_despesa'));
            $this->db->where('nome', $nome_antigo);
			$this->db->update('fecho_de_contas');

			$this->db->set('nome', $this->input->post('nome_despesa'));
            $this->db->where('nome', $nome_antigo);
			$this->db->update('totalizadores');

			// Carregar Notas
			$this->db->from('despesas');
            $despesas["despesas"] = $this->db->get()->result_array();

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Despesa editada com sucesso.";
			$this->load->view("template/header", $alerta);
			$this->load->view('despesas', $despesas);
            $this->load->view('template/footer');
			return;
		}

		public function editar_despesa()
		{
			$nome_despesa = $_GET['n'];

			// Carregar Despesas
			$this->db->from('despesas');
			$this->db->where('nome', $nome_despesa);
			$despesas["despesas"] = $this->db->get()->result_array();

			$this->load->view('template/header');
			$this->load->view('editar_despesa', $despesas);
			$this->load->view('template/footer');
		}

		public function editar_r()
		{
			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];

			$nome_antigo = $_GET['n'];

			$this->db->set('nome', $this->input->post('nome_receita'));
            $this->db->where('nome', $nome_antigo);
			$this->db->update('receitas');
			
			$this->db->set('nome', $this->input->post('nome_receita'));
            $this->db->where('nome', $nome_antigo);
			$this->db->update('balanco');

			$this->db->set('nome', $this->input->post('nome_receita'));
            $this->db->where('nome', $nome_antigo);
			$this->db->update('fecho_de_contas');

			$this->db->set('nome', $this->input->post('nome_receita'));
            $this->db->where('nome', $nome_antigo);
			$this->db->update('totalizadores');

			// Carregar Notas
			$this->db->from('receitas');
            $receitas["receitas"] = $this->db->get()->result_array();

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Receita editada com sucesso.";
			$this->load->view("template/header", $alerta);
			$this->load->view('receitas', $receitas);
            $this->load->view('template/footer');
			return;
		}

		public function editar_receita()
		{
			$nome_receita = $_GET['n'];

			// Carregar Despesas
			$this->db->from('receitas');
			$this->db->where('nome', $nome_receita);
			$receitas["receitas"] = $this->db->get()->result_array();

			$this->load->view('template/header');
			$this->load->view('editar_receita', $receitas);
			$this->load->view('template/footer');
		}

		public function abrir_balanco()
		{
			$this->db->from('gestor');
			$gestor["gestor"] = $this->db->get()->result_array();

			$this->db->from('saldo');
			$saldo["saldo"] = $this->db->get()->result_array();

			$this->load->view('template/header');
			$this->load->view('abrir_balanco', array_merge($gestor, $saldo));
			$this->load->view('template/footer');
		}

		public function abertura_balanco()
		{
			$alerta = [
				"tipo"          => "",
				"mensagem"      => ""
			];

			$this->db->from('despesas');
			$despesas["despesas"] = $this->db->get()->result_array();

			$this->db->from('receitas');
			$receitas["receitas"] = $this->db->get()->result_array();

			$this->db->from('balanco');
			$balanco["balanco"] = $this->db->get()->result_array();

			$this->db->from('saldo');
			$saldo["saldo"] = $this->db->get()->result_array();

			$this->db->from('gestor');
			$gestor = $this->db->get()->result_array();

			if($gestor[0]['conta_aberta'] == 1)
			{
				$this->db->from('gestor');
				$gestor["gestor"] = $this->db->get()->result_array();

				$alerta['tipo'] = "erro";
				$alerta['mensagem'] = "Já existe um balanço aberto.";
				$this->load->view('template/header', $alerta);
				$this->load->view('abrir_balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
				$this->load->view('template/footer');
				return;
			}
			else
			{
				date_default_timezone_set('Europe/London'); 
				// $data_abertura = date("d-m-Y", strtotime($this->input->post('data_abertura')));
				$data_abertura = $this->input->post('data_abertura');

				$this->db->set('conta_aberta', 1);
				$this->db->set('data_abertura', $data_abertura);
				$this->db->update('gestor');

				$this->db->from('gestor');
				$gestor["gestor"] = $this->db->get()->result_array();

				$alerta['tipo'] = "sucesso";
				$alerta['mensagem'] = "Balanço aberto com sucesso.";
				$this->load->view('template/header', $alerta);
				$this->load->view('balanco', array_merge($despesas, $receitas, $balanco, $gestor, $saldo));
				$this->load->view('template/footer');
				return;				
			}
		}

		public function adicionarCredito()
		{
			$valor_credito = $this->input->post('valor_credito');

			if($valor_credito == "")
			{
				// Carregar Saldo
				$this->db->from('saldo');
				$gestor["gestor"] = $this->db->get()->result_array();

				$alerta['tipo'] = "erro";
				$alerta['mensagem'] = "O valor do crédito não pode estar vazio.";
				$this->load->view("template/header", $alerta);
				$this->load->view('saldo', $gestor);
				$this->load->view('template/footer');
				return;
			}

			$dados = [
				"data" 						=> date("Y-m-d"),
				"nome" 						=> "Crédito Adicionado",
				"tipo" 						=> "Crédito",
				"valor"						=> $valor_credito
			];

			$gravar_linha = $this->db->query('INSERT INTO balanco(data, nome, tipo, valor) VALUES(?,?,?,?)', $dados);

			//Adicionar crédito ao saldo
			$this->db->set('saldo', 'saldo + '.$valor_credito, FALSE);
			$this->db->update('saldo');
			
			// Carregar Saldo
			$this->db->from('saldo');
			$gestor["gestor"] = $this->db->get()->result_array();

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Foram adicionados $valor_credito € de crédito ao seu saldo.";
			$this->load->view("template/header", $alerta);
			$this->load->view('saldo', $gestor);
			$this->load->view('template/footer');
			return;
		}

		// Receitas
		public function receitas()
		{
			// Carregar Despesas
			$this->db->from('receitas');
			$receitas["receitas"] = $this->db->get()->result_array();

			$this->load->view('template/header');
			$this->load->view('receitas', $receitas);
			$this->load->view('template/footer');	
		}

		public function criar_receita()
		{
			$alerta = [
                "tipo"          => "",
                "mensagem"      => ""
			];
			
			$nome = $this->input->post("nome_receita");

			if($nome == "")
			{
				// Carregar Receitas
				$this->db->from('receitas');
				$receitas["receitas"] = $this->db->get()->result_array();

				$alerta['tipo'] = "erro";
				$alerta['mensagem'] = "O Nome da Receita não pode ficar em branco.";
				$this->load->view("template/header");
				$this->load->view("receitas", array_merge($alerta, $receitas));
				$this->load->view("template/footer");
				return;
			}

			// Carregar Despesas
			$this->db->from('receitas');
			$this->db->where('nome', $nome);
			$num_linhas = $this->db->get();

			if($num_linhas->num_rows() > 0)
			{
				// Carregar Despesas
				$this->db->from('receitas');
				$receitas["receitas"] = $this->db->get()->result_array();

				$alerta['tipo'] = "erro";
				$alerta['mensagem'] = "O nome '$nome' já existe na lista.";
				$this->load->view("template/header");
				$this->load->view("receitas", array_merge($alerta, $receitas));
				$this->load->view("template/footer");
				return;
			}

			$this->db->from('gestor');
			$gestor = $this->db->get()->result_array();

			$dados = [
				"nome" 				=> $nome
			];

			$query_criar = $this->db->query('INSERT INTO receitas(nome) VALUES(?)', $dados);
			//$query_criar2 = $this->db->query('INSERT INTO totalizadores(nome) VALUES(?)', $dados);

			// Carregar Despesas
			$this->db->from('receitas');
			$receitas["receitas"] = $this->db->get()->result_array();

			$alerta['tipo'] = "sucesso";
			$alerta['mensagem'] = "Receita criada com sucesso.";
			$this->load->view("template/header");
			$this->load->view("receitas", array_merge($alerta, $receitas));
			$this->load->view("template/footer");
			return;
		}

	}

?>