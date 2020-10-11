<?php

class tree_view_model extends inf_model {

    public $GRAPH_WIDTH;
    public $MATRIX;
    public $MAX_LEVEL;
    public $MAX_COL;
    public $POINT;
    public $Tooltip_Array;

    function __construct() {
        parent::__construct();
        $this->Tooltip_Array = array();
    }

    function get_parent_unilevel($child) {

        $this->db->select('sponsor_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $child);
        $this->db->limit(1);
        $query_parent = $this->db->get();
        foreach ($query_parent->result() as $row) {
            $father = $row->sponsor_id;
        }

        return $father;
    }

    function getEncrypt($string) {
        $id_encode = $this->encrypt->encode($string);
        $id_encode = str_replace("/", "_", $id_encode);
        return $encrypt_id = urlencode($id_encode);
    }

    function displayBoard($user_id, $id, $board_id) {

        $this->set_config($id);
        $graphwidth = $this->GRAPH_WIDTH;
        $boxwidth = TREE_BOX_WIDTH;
        $boxheight = TREE_BOX_HIGHT;
        $topmargin = TREE_TOP_MARGIN;
        $leftmargin = TREE_LEFT_MARGIN;
        $maxweight = $this->MATRIX[1][1] ["weight"];

        $unit = $graphwidth / $maxweight;
        $board_icon = 'active.gif';

        for ($level = 1; $level <= $this->MAX_LEVEL; $level++) {

            for ($column = 1; $column <= $this->MAX_COL; $column++) {

# DRAW BOXES

                if ($this->MATRIX[$level][$column]["id"]) {

                    $id_encrypt = $this->getEncrypt($this->MATRIX[$level][$column]["id"]);
                    $id_t = $this->MATRIX[$level][$column]["id"];

                    $x = ($this->MATRIX [$level][$column] ["x"] * $graphwidth) - ($boxwidth / 2) + $leftmargin;

                    $y = ($level * $boxheight) - $boxheight + $topmargin + 20;


                    $display_tree.= "<div align='center' style='position:absolute; top:$y; left:$x;

				padding:0px;

				height:" . ($boxheight - 20) . "px;width:$boxwidth;'><div id=\"member\">";
                    $user_ref_id = $this->getUserRefIdByAutoID($this->MATRIX[$level][$column]["id"], $board_id);
                    $this->load->model('validation_model');
                    $uname = $this->validation_model->IdToUserName($user_ref_id);
                    if ($this->MATRIX[$level][$column]["active"] == "no") {

                        $active = $this->get_active_status($this->MATRIX[$level][$column]["id"]);


                        if ($get_active_status == "yes") {

                            $display_tree.= "<a href=\"ft_chart.php?id={$id_encrypt}\"><img src='" . $this->PUBLIC_URL . "images/freezed.gif' height='48px' width='48px' border='0' title='Account Freezed'/><br>";
                        } else {

                            $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getBoardTree('{$id_t}','{$board_id}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/inactive.png' height='48px' width='48px' border='0' title='Not Activated'/><br>";
                        }
                    } elseif ($this->MATRIX[$level][$column]["active"] == "terminated")
                        $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getBoardTree('{$id_t}','{$board_id}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/terminate.gif' height='48px' width='48px' border='0'  /><br>";
                    elseif ($this->MATRIX[$level][$column][
                            "active"] == "server")
                        $display_tree .= "<a href=\"" . base_url() . "register/user_register/{$id_encrypt}/" . $this->MATRIX [$level][$column]["position"] . "/" . $this->MATRIX[$level][$column]["father_id"] . "\" target=_parent><img src='" . $this->PUBLIC_URL . "images/add.png' height='48px' width='48px' border='0' title='Add new member here...'/><br>";
                    else {
                        $user_ref_id = $this->getUserRefIdByAutoID($this->MATRIX[$level][$column]["id"], 1);
                        $count1 = $this->checkUserExistInAutoBoard($uname, 1);
                        $count2 = $this->checkUserExistInAutoBoard($uname, 2);


                        $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getBoardTree('{$id_t}','{$board_id}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/$board_icon' height='48px' width='48px' border='0'  /><br>";
                    }

                    if ($this->MATRIX[$level][$column]["active"] != "server") {
                        $display_tree .= $this->MATRIX[$level][$column]["name"] . "</a><br>";
                    } else {
                        $display_tree.="ADD HERE" . "</a><br>";
                    }
                    if ($this->MATRIX[$level][$column][
                            "active"] != "server")
                        $display_tree .= "[" . "<font color='#009900'>" . $this->MATRIX[$level][$column]["track_id"] . "</font>]";

                    $display_tree.= "</div>";

                    $display_tree.= "</div>";



# DRAW CONNECTING LINES

                    if ($this->MATRIX[$level][$column]["parent"] == $this->MATRIX[$level][$column - 1]["parent"]) {

                        if ($level > 1) {

# HORIZONTAL LINE

                            $prevx = ( $this->MATRIX[$level][$column - 1]["x"] *
                                    $graphwidth) + $leftmargin;

                            $y2 = $y - 10;

                            $width = $x - $prevx + ($boxwidth / 2);

                            $display_tree.= "<div style='position:absolute; top:$y2; 							left:$prevx; border-top:1px solid #000; width:$width ; 						height:0px'>&nbsp;</div>";
                        }
                    }



# VERTICAL LINE (TOP)

                    if ($level > 1) {

                        $x = ($this->MATRIX [$level][$column]["x"] * $graphwidth) + $leftmargin;

                        $y2 = $y - 10;

                        $display_tree.= "<div style='position:absolute; top:$y2; left:$x;

					border-left:1px solid #000; width:0px;height:10px'>&nbsp;</div>";
                    }

# VERTICAL LINE (BOTTOM)

                    if ($level < $this->MAX_LEVEL && $this->MATRIX[$level][$column]["children"]) {

                        $x = ($this->MATRIX [$level][$column]["x"] * $graphwidth) + $leftmargin;

                        $y2 = $y + $boxheight - 20 + 1;

                        $display_tree.= "<div style='position:absolute; top:$y2; left:$x;

					border-left:1px solid #000; width:0px;height:10px'>&nbsp;</div>";
                    }



# "REDRAW" ICON

                    if ($level == 1) {

                        $this->db->select('father_id');
                        $this->db->from("auto_board_$board_id");
                        $this->db->where('id', $this->MATRIX[$level][$column]["id"]);
                        $this->db->limit(1);
                        $query_parent = $this->db->get();
                        $row = $query_parent->row_array();
                        $root = $row["father_id"];

                        if ($user_id > $root) {
                            $root = $this->MATRIX[$level][$column]["id"];
                        }
                    } else {
                        $root = $this->MATRIX[$level][$column]["id"];
                    }

                    if ($root) {

                        $x = ($this->MATRIX [$level] [$column]["x"] * $graphwidth) - 8 + $leftmargin;

                        $url_encrypted_id = $this->getEncrypt($root);

                        $loged_user_id = $this->LOG_USER_ID;
                        $inf_sess = $this->session->userdata('inf_logged_in');
                        $user_type = $inf_sess['user_type'];
                        if ($user_type == 'employee') {
                            $this->load->model('validation_model');
                            $loged_user_id = $this->validation_model->getAdminId();
                        }

                        $auto_board_id = $this->getBoardId($board_id, $loged_user_id);

                        if (( $this->MATRIX [$level][$column]["active"] != "server") and $this->MATRIX[$level][$column]["id"] != $auto_board_id) {
                            $up_link = $this->get_parent_board($this->MATRIX[$level][$column]["id"], $board_id);
                            if (( $this->MATRIX [$level][$column]["active"] != "server") and $this->MATRIX[$level][$column]["id"] != $auto_board_id) {

                                $display_tree.= "<div title='UP' onclick=\"getBoardTree('$up_link','$board_id');\"

					style='position:absolute; top:" . ($y - 9) . "; left:$x;

					border:0px solid #000; cursor:pointer; '><img src='" . $this->PUBLIC_URL . "images/up.png' height='16px' width='16px' border='0' /></div>\n";
                            }
                        }
                    }
                }
            }
        }

        return $display_tree;
    }

    public function getLegLeftRightCount($user_id) {
        $total_left_count = $total_right_count = $total_left_carry = $total_right_carry = 0;
        $this->db->select('total_left_count,total_right_count');
        $this->db->select('total_left_carry,total_right_carry');
        $this->db->from('leg_details');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $total_left_count = $row->total_left_count;
            $total_right_count = $row->total_right_count;
            $total_left_carry = $row->total_left_carry;
            $total_right_carry = $row->total_right_carry;
        }
        $arr = array();
        $arr['total_left_count'] = $total_left_count;
        $arr['total_left_carry'] = $total_left_carry;
        $arr['total_right_count'] = $total_right_count;
        $arr['total_right_carry'] = $total_right_carry;
        return $arr;
    }

}
