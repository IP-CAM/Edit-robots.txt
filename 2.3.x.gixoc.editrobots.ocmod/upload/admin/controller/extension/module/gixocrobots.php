<?php
class ControllerExtensionModuleGixocrobots extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/gixocrobots');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(isset($this->request->post['robots'])){
				$file = str_replace("system/", "", DIR_SYSTEM) . 'robots.txt';

				$handles = fopen($file, 'w+'); 

				fwrite($handles, $this->request->post['robots']);

				fclose($handles); 
				
				$this->session->data['success'] = $this->language->get('text_success');
				
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');

		$data['entry_create'] = $this->language->get('entry_create');
		$data['entry_clean'] = $this->language->get('entry_clean');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/gixocrobots', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/gixocrobots', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);

		$data['text'] = '';

		$file = str_replace("system/", "", DIR_SYSTEM) . 'robots.txt';

		if (file_exists($file)) {
			$data['text'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} 

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->response->setOutput($this->load->view('extension/module/gixocrobots', $data));
	}

	public function create_robots(){
		$text = "User-agent: *
Disallow: /*route=account/
Disallow: /*route=affiliate/
Disallow: /*route=checkout/
Disallow: /*route=product/search
Disallow: /index.php?route=product/product*&manufacturer_id=
Disallow: /admin
Disallow: /catalog
Disallow: /system
Disallow: /*?sort=
Disallow: /*&sort=
Disallow: /*?order=
Disallow: /*&order=
Disallow: /*?limit=
Disallow: /*&limit=
Disallow: /*?filter=
Disallow: /*&filter=
Disallow: /*?filter_name=
Disallow: /*&filter_name=
Disallow: /*?filter_sub_category=
Disallow: /*&filter_sub_category=
Disallow: /*?filter_description=
Disallow: /*&filter_description=
Disallow: /*?tracking=
Disallow: /*&tracking=

User-agent: Yandex
Disallow: /*route=account/
Disallow: /*route=affiliate/
Disallow: /*route=checkout/
Disallow: /*route=product/search
Disallow: /index.php?route=product/product*&manufacturer_id=
Disallow: /admin
Disallow: /catalog
Disallow: /system
Disallow: /*?sort=
Disallow: /*&sort=
Disallow: /*?order=
Disallow: /*&order=
Disallow: /*?limit=
Disallow: /*&limit=
Disallow: /*?filter=
Disallow: /*&filter=
Disallow: /*?filter_name=
Disallow: /*&filter_name=
Disallow: /*?filter_sub_category=
Disallow: /*&filter_sub_category=
Disallow: /*?filter_description=
Disallow: /*&filter_description=
Clean-param: tracking";
		$this->response->setOutput($text);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/gixocrobots')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}