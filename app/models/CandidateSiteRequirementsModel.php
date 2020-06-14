<?php

class CandidateSiteRequirementsModel extends Model{

    public function save_update_requirements($params){
            
        if(isset($params['id']) && $params['id'] > 0){
            //update
            $update = $this->db->executeUpdate('UPDATE tbcandidate_site_requirements '
                    . 'SET '
                    . 'web_browsers = ?, '
                    . 'devices = ?, '
                    . 'os = ?, '
                    . 'cookies = ?, '
                    . 'camera = ?, '
                    . 'microphone = ?, '
                    . 'last_update = ? '
                    . 'WHERE '
                    . 'id = ? ', 
                    array($params['web_browsers'], $params['devices'], $params['os'], $params['cookies'], $params['camera'], $params['microphone'], date('Y-m-d H:i:s'), $params['id']));
            
        } else {
            //insert 
            $this->queryBuilder->insert('tbcandidate_site_requirements')
                                ->values(['web_browsers' => '?', 'devices' => '?' , 'os' => '?', 'cookies' => '?', 'camera' => '?', 'microphone' => '?', 'last_update' => '?'])
                                ->setParameters([$params['web_browsers'], $params['devices'], $params['os'], $params['cookies'], $params['camera'], $params['microphone'], date('Y-m-d H:i:s')]);
            $this->queryBuilder->execute();

        }
        
    }
    
    public function get_requirements(){
        
        $requirements = $this->db->fetchAssoc('SELECT * FROM tbcandidate_site_requirements LIMIT 1');
        return $requirements;
        
    }
 
    
}
