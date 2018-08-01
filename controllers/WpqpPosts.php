<?php

class WpqpPosts extends WpqpController {
    private static $inst = null;
    
    public static function &getInst() {
        if (self::$inst == null) {
            self::$inst = new WpqpPosts();
        }
        
        return self::$inst;
    }
    
    private function parse_args($arg_str) {
        $res = array();
        $tmpstr = trim($arg_str);
        
        while ($pos = strpos($tmpstr, '=')) {
            $key = substr($tmpstr, 0, $pos);
            $tmpstr = substr($tmpstr, $pos + 1);
            
            // Get the value out
            $matches = array();
            preg_match('/\"([^\"]*)\"/', $tmpstr, $matches);
            
            $value = $matches[1];
            
            $tmpstr = trim(preg_replace('/\"([^\"]*)\"/', '', trim($tmpstr), 1));
            
            $res[$key] = $value;
        }
        
        return $res;
    }
    
    
    
    public function __construct() {
        parent::__construct();
    }
    
    /*
        SavePost - is called when a post is being saved.
        It should look for the [qpic ...] shortcode and register it into the
        database. Also, if can look for img tags, and register them into wpqp.
        This allows for the admin or blogger to later upload the image
    */
    public function HandleSavePost($post_id) {
        $post = get_post($post_id);

        if ($post->post_parent > 0) {
            $post_id = $post->post_parent;
        }

        //die('Got a post: ' . $post->post_name);

        $this->loadModel('Instance');
        
        // Get the shortcode regex?
        $pattern = get_shortcode_regex();
        $matches = array();
        $identifiers = array();
        if (preg_match_all('/' . $pattern . '/s', $post->post_content, $matches)) {
            // Loop each match
            for ($i = 0; $i < count($matches[0]) ; $i++) {
                // [3] is our args
                $tag = $matches[2][$i];
                $args_str = $matches[3][$i];
                if ($tag == 'qpic') {
                    // We need to process this tags args
                    $args = $this->parse_args($args_str);
                    
                    $args = shortcode_atts(array(
                                'media' => null,
                                'name' => null,
                                'workflow' => null),
                                $args, 'qpic');
                    
                    $identifiers[] = $args['name'];
                    
                    // Check if we are updating or inserting
                    $exists = $this->instance_model->instance_exists($post_id, $args['name']);
                    
                    if (!$exists) {
                        $this->instance_model->create_instance($post_id, $args['name'], $args['media'], $args['workflow']);
                    } else {
                        $this->instance_model->update_instance($post_id, $args['name'], $args['media'], $args['workflow']);
                    }
                }
            }
        }

        $db_idents = $this->instance_model->list_post_identifiers($post_id);
        
        foreach($db_idents as $ident) {
            if (!in_array($ident, $identifiers)) {
                $this->instance_model->delete_instance($post_id, $ident);
            }
        }
    }

    public function HandleDeletePost($post_id) {
        $this->loadModel('Instance');

        $post = get_post($post_id);

        if ($post->post_parent > 0) {
            $post_id = $post->post_parent;
        }
        
        $this->instance_model->delete_post_instances($post_id);
    }

    public function HandleAddAttachement($media_id) {
       //die('Uploading attachement: ' . $media_id);

       // This
    }

    public function HandlePreFilter($file) {

        // Here we can actually run a workflow on the image,
        // caching the results for use by shortcodes

        return $file;
    }

    public function ShortcodeQPic($attr, $content=null, $tag=null) {
        return '<strong>TAG: ' . $tag . '</strong>';
    }
    
    public function Test(&$req) {
        return 'Hello ' . $req['name'] . ' ReqType: ' . get_class($req);
    }
}