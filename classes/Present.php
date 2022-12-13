<?php 

class Present{
	
	public static function add($data){

        if(!isset($data['title'])){
            $_SESSION['error'] = 'title not set';
            return false;
        }
        if(!isset($data['type'])){
            $_SESSION['error'] = 'type not set';
            return false;
        }
        if(!isset($data['quantity'])){
            $_SESSION['error'] = 'quantity not set';
            return false;
        }

        for($i=1;$i<=$data['quantity']; $i++) {
            DB::query("INSERT INTO presents SET title=:title, type=:type, created_at=NOW()", ['title' => $data['title'], 'type' => $data['type']]);
        }
		return true;
	}

    public static function setStatus($status,$id){
        DB::query("UPDATE presents SET status=:status WHERE id=:id", ['status' => $status,'id'=>$id]);
        return true;
    }

    public static function count(){

        $result = DB::query("SELECT COUNT(id) as cnt FROM presents WHERE status=0");
        if(count($result)) {
            return $result[0]['cnt'];
        }
        return 0;
    }

    public static function max(){
        $result = DB::query("SELECT MAX(id) as mid FROM presents WHERE status=0");
        if(count($result)) {
            return $result[0]['mid'];
        }
        return 0;
    }


    public static function off(){

        $results = DB::query("SELECT id FROM presents WHERE status=1");
        if(count($results)) {
            foreach ($results as $item) {
                $_result[] = $item['id'];
            }
            return $_result;
        }

        return [0];

    }

    public static function on(){

        $results = DB::query("SELECT id,title,type FROM presents WHERE status=0");
        if(count($results)) {
            foreach ($results as $item) {
                $_result[] = $item;
            }
            return json_encode($_result,JSON_UNESCAPED_UNICODE);
        }

        return [0];

    }


}