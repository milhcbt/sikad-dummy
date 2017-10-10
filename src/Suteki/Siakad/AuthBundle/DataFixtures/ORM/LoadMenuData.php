<?php
namespace  Suteki\Siakad\AuthBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Suteki\Siakad\AuthBundle\Entity\Menu;



class LoadMenuData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
      
        $role = $manager->getRepository("AuthBundle:Role")->findOneBy(array('name' => 'Admin IF'));

        $dasboard = new Menu();
        $element = new Menu();
        $forms = new Menu();
        $tables = new Menu();
        $documentation = new Menu();
        # menu root
        $dasboard->setTitle("Dashboard");
        $dasboard->setIcon("fa fa-flask");
        $dasboard->setDescription("overview of system");
        $role->addMenu($dasboard);

        $element->setTitle("UI Elements");
        $element->setIcon("fa fa-toggle-on");
        $role->addMenu($element);

        $forms->setTitle("Forms");
        $forms->setIcon("fa fa-tint");
        $role->addMenu($forms);

        $tables->setTitle("Tables");
        $tables->setIcon("fa fa-tag");
        $role->addMenu($tables);

        $documentation->setTitle("Documentation");
        $documentation->setIcon("fa fa-folder");
        $role->addMenu($documentation);

        # anak dari UI Elements
        $buttons = new Menu();
        $general = new Menu();
        $tabs = new Menu();
        $progress = new Menu();
        $pagging = new Menu();
        $Sliders = new Menu();
        $Portlets = new Menu();
        $Notifications = new Menu();
        $Alerts = new Menu();
        $icons = new Menu();
        
        $buttons->setTitle("Buttons");
        $buttons->setParent($element);

        $general->setTitle("General");
        $general->setParent($element);

        $tabs->setTitle("Tabs & Accordions");   
        $tabs->setParent($element);

        $progress->setTitle("Progress Bars");
        $progress->setParent($element);

        $pagging->setTitle("Pagination");
        $pagging->setParent($element);

        $Sliders->setTitle("Sliders");
        $Sliders->setParent($element);

        $Portlets->setTitle("Portlets");
        $Portlets->setParent($element);

        $Notifications->setTitle("Notifications");
        $Notifications->setParent($element);

        $Alerts->setTitle("Alerts");
        $Alerts->setParent($element);

        $icons->setTitle("icons");
        $icons->setParent($element);

        ## anak dari icons
        $Fontawesome = new Menu();
        $Feather = new Menu();
        $Climacon = new Menu();

        $Fontawesome->setTitle("Fontawesome");
        $Fontawesome->setParent($icons);

        $Feather->setTitle("Feather");
        $Feather->setParent($icons);

        $Climacon->setTitle("Climacon");
        $Climacon->setParent($icons);

        # anak dari form
        $bfd = new Menu();
        $ac = new Menu();
        $Wizard = new Menu();
        $editors = new Menu();
        $validation = new Menu();
        $im = new Menu();

        $bfd->setTitle("Basic Forms Demo");
        $bfd->setParent($forms);

        $ac->setTitle("Advanced Components");
        $ac->setParent($forms);

        $Wizard->setTitle("Wizard");
        $Wizard->setParent($forms);

        $editors->setTitle("Editors");
        $editors->setParent($forms);

        $validation->setTitle("Validation");
        $validation->setParent($forms);

        $im->setTitle("Input Masks");
        $im->setParent($forms);

        # anak dari tables
        $bt = new Menu();
        $rt = new Menu();
        $dt = new Menu();
        $edit = new Menu();
        
        $bt->setTitle("Basic Tables");
        $bt->setParent($tables);

        $rt->setTitle("Responsive Tables");
        $rt->setParent($tables);

        $dt->setTitle("Data Tables");
        $dt->setParent($tables);

        $edit->setTitle("Editable editable");
        $edit->setParent($tables);


        $manager->persist($dasboard);
        $manager->persist($element);
        $manager->persist($forms);
        $manager->persist($tables);
        $manager->persist($documentation);

        $manager->persist($buttons);
        $manager->persist($general);
        $manager->persist($tabs);
        $manager->persist($progress);
        $manager->persist($pagging);
        $manager->persist($Sliders);
        $manager->persist($Portlets);
        $manager->persist($Notifications);
        $manager->persist($Alerts);
        $manager->persist($icons);

        $manager->persist($Fontawesome);
        $manager->persist($Feather);
        $manager->persist($Climacon);

        $manager->persist($bfd);
        $manager->persist($ac);
        $manager->persist($Wizard);
        $manager->persist($editors);
        $manager->persist($validation);
        $manager->persist($im);

        $manager->persist($bt);
        $manager->persist($rt);
        $manager->persist($dt);
        $manager->persist($edit);

        $manager->persist($role);
        
        $manager->flush();

    }


    public function insert(ObjectManager $manager)
    {
        
        $data = $this->getData();  
       
        for($i=0;$i<count($data);$i++) {
            echo " row : ".$i." \n";
            $raws = new Menu();
            echo "# parent 0 : ".$data[$i]['title']." \n";
            $raws->setTitle($data[$i]['title']);
            $raws->setIcon($data[$i]['icon']);
            if(isset($data[$i]['path'])){
                $raws->setPath($data[$i]['path']);
                $manager->persist($raws);
                $manager->flush();
            }else if(isset($data[$i]['children'])){
                $manager->persist($raws);
                $manager->flush();
                echo "# child 1 > jml : ".count($data[$i]['children'])."\n"; 
                for($j=0;$j<count($data[$i]['children']);$j++)
                {
                    $raws1 = new Menu();
                    echo "jml row j : ".$j." child >  ".$data[$i]['children'][$j]['title']." \n";

                    $raws1->setTitle($data[$i]['children'][$j]['title']);
                    $raws1->setPath($data[$i]['children'][$j]['path']);
                    $raws1->setDescription($data[$i]['title']." > ".$data[$i]['children'][$j]['title']);
                    $p0 = $manager->getRepository("AuthBundle:Menu")->findOneBy(array("title"=>$data[$i]['title']));
                    $p0_id = $p0->getId();
                    echo " parent id [0]: ".$p0_id." \n";
                    $raws1->setParent(intval($p0_id));
                    $manager->persist($raws1);
                    $manager->flush();
                    
                    if(isset($data[$i]['children'][$j]['children'])){
                        echo "### childs 2 > jml child :".count($data[$i]['children'][$j]['children'])."\n";
                        
                        for($k=0;$k<count($data[$i]['children'][$j]['children']);$k++)
                        {
                            $raws2 = new Menu();
                            echo " row k : ".$k." child > child  : ".$data[$i]['children'][$j]['children'][$k]['title']." \n";
                            
                            $raws2->setTitle($data[$i]['children'][$j]['children'][$k]['title']);
                            $raws2->setPath($data[$i]['children'][$j]['children'][$k]['path']);
                            $raws2->setDescription($data[$i]['children'][$j]['title']." > ".$data[$i]['children'][$j]['children'][$k]['title']);
                            $p1 = $manager->getRepository("AuthBundle:Menu")->findOneBy(array("title"=>$data[$i]['children'][$j]['title']));
                            $p1_id = $p1->getId();
                            echo " parent id [1]: ".$p1_id." \n";
                            $raws2->setParent(intval($p1_id));
                            
                            $manager->persist($raws2);
                            $manager->flush();
                        }
                    }
                   
                }
                
            }
            $manager->persist($raws);
            $manager->flush();
            
         }
        
        //print_r($raws);
        
    }

    private function getData()
    {
        $menu =array(
                array(
                    "title"=>"Dashboard",
                    "icon"=> "fa fa-flask",
                    "path"=>"/#/admin/home"
                ),
                array(
                "title"=>"UI Elements",
                "icon"=> "fa fa-toggle-on",
                "children"=>array(
                    array("title"=> "Buttons","path"=> "/#/ui/ui-buttons"),
                    array("title"=> "General","path"=> "/#/ui/ui-general"),
                    array("title"=> "Tabs & Accordions","path"=> "/#/ui/ui-tabs-accordion"),
                    array("title"=> "Progress Bars","path"=> "/#/ui/ui-progressbars"),
                    array("title"=> "Pagination","path"=> "/#/ui/ui-pagination"),
                    array("title"=> "Sliders","path"=> "/#/ui/ui-sliders"),
                    array("title"=> "Portlets","path"=> "/#/ui/ui-portlets"),
                    array("title"=> "Notifications","path"=> "/#/ui/ui-notifications"),
                    array("title"=> "Alerts","path"=> "/#/ui/ui-alert"),
                    array("title"=> "icons",
                          "path"=> "toggle-accordion",
                          "children"=>array(
                                array("title"=>"Fontawesome","path"=>"/#/ui/ui-fontawesome"),
                                array("title"=>"Feather","path"=>"/#/ui/ui-feather"),
                                array("title"=>"Climacon","path"=>"/#/ui/ui-climacon")
                          )
                        ),                                        
                  )             
                ),
                array(
                "title"=>"Forms",
                "icon"=> "fa fa-tint",
                "children"=>array(
                    array( "title"=>"Basic Forms Demo","path"=>"/#/form/basic"),
                    array( "title"=>"Advanced Components","path"=>"/#/form/form-advanced"),
                    array( "title"=>"Wizard","path"=>"/#/form/form-wizard"),
                    array( "title"=>"Editors","path"=> "/#/form/form-editors"),
                    array( "title"=>"Validation","path"=>"/#/form/form-validation"),
                    array( "title"=> "Input Masks","path"=>"/#/form/form-masks"),
                  )
                ),
                array(
                "title"=>"Tables",
                "icon"=> "fa fa-tag",
                "children"=>array(
                    array( "title"=>"Basic Tables","path"=>"/#/table/table-basic"),
                    array( "title"=>"Responsive Tables","path"=>"/#/table/responsive"),
                    array( "title"=>"Data Tables","path"=>"/#/table/table-datatable"),
                    array( "title"=>"Editable editable","path"=> "/#/admin/table-datatable"),
                  )
                ),
                array(
                "title"=>"Documentation",
                "icon"=> "fa fa-folder",
                "path"=> "/#/admin/docs",
                ),
            );
          return $menu;
      
    }

    
}