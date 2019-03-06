<?php

namespace Drupal\extended_siteconfig\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInfoForm extends SiteInformationForm {
 
   /**
   * {@inheritdoc}
   */
	  public function buildForm(array $form, FormStateInterface $form_state) {
		$site_config = $this->config('system.site');
		$form =  parent::buildForm($form, $form_state);

		/*adding custom siteapikey text field to site information form*/
		$form['site_information']['siteapikey'] = [
			'#type' => 'textfield',
			'#title' => t('Site API Key'),
			'#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
			'#description' => t("Custom field to set the API Key"),
		];

		$form['actions']['submit']['#value'] = $site_config->get('siteapikey') ? t('Update Configuration') : t('Save Configuration');

		return $form;
	}
	
	  public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config('system.site')
		  ->set('siteapikey', $form_state->getValue('siteapikey'))
		  ->save();

		$form_state->getValue('siteapikey') ? drupal_set_message(' Site API Key has been saved with ' . $form_state->getValue('siteapikey')) : '';
		
		parent::submitForm($form, $form_state);
	  }
}