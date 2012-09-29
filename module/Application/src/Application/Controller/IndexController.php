<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function render($data)
    {
    	$json  = array();

    	if($data->hasNext())
			{
				while($data->hasNext())
				{
    			$json[] = $data->getNext();
    		}
			}

			echo json_encode($json);
    }

    public function parksAction()
    {
    	$mongodb = $GLOBALS['mongodb'];

    	$this->render($mongodb->parkpoints->find());

    	return $this->response;
    }

    public function parkAction()
    {
    	$mongodb = $GLOBALS['mongodb'];

    	$event   = $this->getEvent();
			$matches = $event->getRouteMatch();
			$park    = $matches->getParam("park");

			$park = $mongodb->parkpoints->findOne(array('_id' => new \MongoId($park)));

    	echo json_encode($park);

			return $this->response;
    }

    public function nearAction()
    {
    	$mongodb = $GLOBALS['mongodb'];

    	$lat = floatval($_GET['lat']);
    	$lon = floatval($_GET['lon']);

    	$this->render($mongodb->parkpoints->find(array('pos' => array('$near' => array($lon,$lat)))))	;

    	return $this->response;
    }

    public function namedNearAction()
    {
    	$mongodb = $GLOBALS['mongodb'];
    	$event   = $this->getEvent();
			$matches = $event->getRouteMatch();
			$name    = $matches->getParam("name");

			$lat = floatval($_GET['lat']);
    	$lon = floatval($_GET['lon']);

    	$this->render($mongodb->parkpoints->find(array('Name' => array('$regex' => $name, '$options' => 'i'), 'pos' => array('$near' => array($lon,$lat)))));

			return $this->response;
    }

    public function testAction()
    {
    	$mongodb = $GLOBALS['mongodb'];
    	echo "<strong>It actually worked</strong>";
    	return $this->response;
    }

}
