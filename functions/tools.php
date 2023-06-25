<?php

    function getCategories($bdd){
        $sql = "SELECT * FROM category";

        $req = $bdd->prepare($sql);
        $req->execute();
        $res = $req->fetchall(PDO::FETCH_ASSOC);

        return $res;
    }

    function getDishes($bdd, $id) {

        switch ($id) {

            case 1:

                $sql = "SELECT dish.*, category.name AS category_name FROM dish
                JOIN category ON category_id = category.id";
                break;
            default:

                $sql = "SELECT dish.*, category.name AS category_name FROM dish
                JOIN category ON category_id = category.id
                WHERE author_id =  ?";
                break;
        }

        $req = $bdd->prepare($sql);
        if($id != 1) {
            $req->execute([$id]);
        } else {
            $req->execute();
        }
        $res = $req->fetchall(PDO::FETCH_ASSOC);

        return $res;
    }

    function getMenus($bdd, $id) {
        switch ($id) {

            case 1:

                $sql = "SELECT * FROM menu";
                break;
            default:

                $sql = "SELECT * FROM menu
                WHERE author_id =  ?";
                break;
        }

        $req = $bdd->prepare($sql);
        if($id != 1) {
            $req->execute([$id]);
        } else {
            $req->execute();
        }
        $res = $req->fetchall(PDO::FETCH_ASSOC);

        return $res;
    }

    function getRestaurants($bdd, $id) {

        switch ($id) {

            case 1:

                $sql = "SELECT * FROM restaurant";
                break;
            default:

                $sql = "SELECT * FROM restaurant
                WHERE owner_id =  ?";
                break;
        }

        $req = $bdd->prepare($sql);
        if($id != 1) {
            $req->execute([$id]);
        } else {
            $req->execute();
        }
        $res = $req->fetchall(PDO::FETCH_ASSOC);

        return $res;
    }

    function getDishIngredients($bdd, $dish) {
        $sql = "SELECT * FROM dish_ingredient WHERE dish_id = ?";

        $req = $bdd->prepare($sql);
        $req->execute([$dish]);
        $res = $req->fetchall(PDO::FETCH_ASSOC);

        return $res;
    }

    function getMenuDishes($bdd, $menu) {
        $sql = "SELECT dish.name, dish.price FROM menu_dish
                JOIN dish ON dish_id = dish.id
                WHERE menu_id = ?";

        $req = $bdd->prepare($sql);
        $req->execute([$menu]);
        $res = $req->fetchall(PDO::FETCH_ASSOC);

        return $res;
    }

    function checkImage($image, $imageFile){
        $check = getimagesize($image["tmp_name"]);

        if($check == false) {
            return false;
        }

        if(file_exists($imageFile)) {
            return false;
        }

        if($image["size"] > 500000) {
            return false;
        }

        return true;
    }
?>