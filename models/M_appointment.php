<?php

class M_appointment extends CI_Model{


    public function __construct() {
        parent::__construct();
        $this->secretkey_server = $this->config->item('secretkey_server');
        $this->base_url = $this->config->item('base_url');
        $this->load->model('M_base','base');
    }


    function list_appointment($userid,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        $exec_user = $this->db->query($sql_user)->row();

        if (isset($exec_user)) {
            $userid = $exec_user->id;
            


            //today
            //session 1 08:00-12:00
            $session1_start_date = date("Y-m-d ")."08:00:00";
            $session1_end_date = date("Y-m-d ")."11:59:59";
            
            $data_session1 = $this->db->query("SELECT COUNT(*) AS QTY FROM appointment 
                WHERE doctor = '$userid' AND date >= '$session1_start_date' AND date <= '$session1_end_date' ")->row();
            //session 2 12:00-16:00
            $session2_start_date = date("Y-m-d ")."12:00:00";
            $session2_end_date = date("Y-m-d ")."13:59:59";
            
            $data_session2 = $this->db->query("SELECT COUNT(*) AS QTY FROM appointment 
                WHERE doctor = '$userid' AND date >= '$session2_start_date' AND date <= '$session2_end_date' ")->row();
            //session 3 16:00-20:00
            $session3_start_date = date("Y-m-d ")."16:00:00";
            $session3_end_date = date("Y-m-d ")."19:59:59";
            
            $data_session3 = $this->db->query("SELECT COUNT(*) AS QTY FROM appointment 
                WHERE doctor = '$userid' AND date >= '$session3_start_date' AND date <= '$session3_end_date' ")->row();
            //session 4 20:00-24:00
            $session4_start_date = date("Y-m-d ")."20:00:00";
            $session4_end_date = date("Y-m-d ")."23:59:59";
            
            $data_session4 = $this->db->query("SELECT COUNT(*) AS QTY FROM appointment 
                WHERE doctor = '$userid' AND date >= '$session4_start_date' AND date <= '$session4_end_date' ")->row();

            $data = array(
                'ResponseCode' => '00',
                'Status' => 'Success',
                'Message' => 'List Data appointment',
                'Data' => array(
                    'Session1' => array(
                        'total_patient' => $data_session1->QTY,
                        'session_time' => '08:00-12:00'
                    ),
                    'Session2' => array(
                        'total_patient' => $data_session2->QTY,
                        'session_time' => '12:00-16:00'
                    ),
                    'Session3' => array(
                        'total_patient' => $data_session3->QTY,
                        'session_time' => '16:00-20:00'
                    ),
                    'Session4' => array(
                        'total_patient' => $data_session4->QTY,
                        'session_time' => '20:00-24:00'
                    )
                )
            );

            return $data;

        }else{
            return array('Status'=>'Failed',
                    'Message'=>'User not found',
                    'ResponseCode'=>'03'
            );
        }
        
    }

    function list_session_appointment($session_id,$userid,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        $exec_user = $this->db->query($sql_user)->row();

        if (isset($exec_user)) {
            $userid = $exec_user->id;
            


            //today
            //session 1 08:00-12:00
            if ($session_id == 1) {
                $session1_start_date = date("Y-m-d ")."08:00:00";
                $session1_end_date = date("Y-m-d ")."11:59:59";
                
                $data_session = $this->db->query("SELECT COUNT(*) AS QTY FROM appointment 
                    WHERE doctor = '$userid' AND date >= '$session1_start_date' AND date <= '$session1_end_date' ")->row();

                $data_list_session = $this->db->query("SELECT * FROM appointment 
                    WHERE doctor = '$userid' AND date >= '$session1_start_date' AND date <= '$session1_end_date' ")->result();

            }elseif ($session_id == 2) {
                //session 2 12:00-16:00
                $session2_start_date = date("Y-m-d ")."12:00:00";
                $session2_end_date = date("Y-m-d ")."13:59:59";
                
                $data_session = $this->db->query("SELECT COUNT(*) AS QTY FROM appointment 
                    WHERE doctor = '$userid' AND date >= '$session2_start_date' AND date <= '$session2_end_date' ")->row();

                $data_list_session = $this->db->query("SELECT * FROM appointment 
                    WHERE doctor = '$userid' AND date >= '$session2_start_date' AND date <= '$session2_end_date' ")->result();
            }elseif ($session_id == 3) {
                //session 3 16:00-20:00
                $session3_start_date = date("Y-m-d ")."16:00:00";
                $session3_end_date = date("Y-m-d ")."19:59:59";
                
                $data_session = $this->db->query("SELECT COUNT(*) AS QTY FROM appointment 
                    WHERE doctor = '$userid' AND date >= '$session3_start_date' AND date <= '$session3_end_date' ")->row();

                $data_list_session = $this->db->query("SELECT * FROM appointment 
                    WHERE doctor = '$userid' AND date >= '$session3_start_date' AND date <= '$session3_end_date' ")->result();
            }elseif ($session_id == 4) {
                //session 4 20:00-24:00
                $session4_start_date = date("Y-m-d ")."20:00:00";
                $session4_end_date = date("Y-m-d ")."23:59:59";
                
                $data_session = $this->db->query("SELECT COUNT(*) AS QTY FROM appointment 
                    WHERE doctor = '$userid' AND date >= '$session4_start_date' AND date <= '$session4_end_date' ")->row();

                $data_list_session = $this->db->query("SELECT * FROM appointment 
                    WHERE doctor = '$userid' AND date >= '$session4_start_date' AND date <= '$session4_end_date' ")->result();
            }else{
                return array(
                    'Status' => 'Failed',
                    'Message' => 'Please check session date',
                    'ResponseCode' => '02' 
                );
            }
            

            $data = array(
                'ResponseCode' => '00',
                'Status' => 'Success',
                'Message' => 'List Data appointment',
                'Data' => array(
                    'total_patient' => $data_session->QTY,
                    'session_time' => '08:00-12:00',
                    'session_data' => $data_list_session

                )
            );

            return $data;

        }else{
            return array('Status'=>'Failed',
                    'Message'=>'User not found',
                    'ResponseCode'=>'03'
            );
        }
        
    }

    function add_appointment($patient_id,$appointment_no,$appointment_datetime,$priority,$patient_name,$gender,$email,$mobile_no,$specialist,$doctor,$amount,$message,$appointment_status,$source,$is_opd,$is_ipd,$live_constultant,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        // $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        // $exec_user = $this->db->query($sql_user)->row();

        // if (isset($exec_user)) {

            
            $data_insert = array(
                'patient_id' => $patient_id,
                'appointment_no' => $appointment_no, 
                'date' => $appointment_datetime,
                'priority' => $priority,
                'patient_name' => $patient_name,
                'gender' => $gender,
                'email' => $email,
                'mobileno' => $mobile_no,
                'specialist' => $specialist,
                'doctor' => $doctor,
                'amount' => $amount,
                'message' => $message,
                'appointment_status' => $appointment_status,
                'source' => $source,
                'is_opd' => $is_opd,
                'is_ipd' => $is_ipd,
                'live_consult' => $live_constultant,
                'created_at' => date('Y-m-d h:i:s')
            );
            $data_execute = $this->db->insert('appointment',$data_insert);
            if ($data_execute = TRUE) {
                $data = array(
                    'ResponseCode' => '00',
                    'Status' => 'Success',
                    'Message' => 'Success Add appointment' 
                );
            }else{
                $data = array(
                    'ResponseCode' => '02',
                    'Status' => 'Failed',
                    'Message' => 'Failed Add appointment' 
                );
            }
            

            return $data;

        // }else{
        //     return array('Status'=>'Failed',
        //             'Message'=>'User not found',
        //             'ResponseCode'=>'03'
        //     );
        // }
        
    }

    function detail_appointment($appointment_id,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        // $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        // $exec_user = $this->db->query($sql_user)->row();

        // if (isset($exec_user)) {

            $sql_days = "SELECT * FROM appointment WHERE id = '$appointment_id' ";

            $data_exec = $this->db->query($sql_days)->row();

            if (isset($data_exec)) {
                $data = array(
                    'ResponseCode' => '00',
                    'Status' => 'Success',
                    'Message' => 'List Data appointment',
                    'Data' => $data_exec
                );
            }else{
                $data = array(
                    'ResponseCode' => '03',
                    'Status' => 'Failed',
                    'Message' => 'Not Found Data appointment', 
                );
            }
            

            return $data;

        // }else{
        //     return array('Status'=>'Failed',
        //             'Message'=>'User not found',
        //             'ResponseCode'=>'03'
        //     );
        // }
        
    }



    function update_appointment($appointment_id,$patient_id,$appointment_no,$appointment_datetime,$priority,$patient_name,$gender,$email,$mobile_no,$specialist,$doctor,$amount,$message,$appointment_status,$source,$is_opd,$is_ipd,$live_constultant,$secretkey){
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token '.$secretkey,
                'ResponseCode' => '01' 
            );
        }

        // $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        // $exec_user = $this->db->query($sql_user)->row();

        // if (isset($exec_user)) {


            //check data appointment
            $sql_appointment = "SELECT id FROM appointment WHERE id = '$appointment_id'";
            $exec_appointment = $this->db->query($sql_appointment)->row();

            if (isset($exec_appointment)) {
                $data_update = array(
                'patient_id' => $patient_id,
                'appointment_no' => $appointment_no, 
                'date' => $appointment_datetime,
                'priority' => $priority,
                'patient_name' => $patient_name,
                'gender' => $gender,
                'email' => $email,
                'mobileno' => $mobile_no,
                'specialist' => $specialist,
                'doctor' => $doctor,
                'amount' => $amount,
                'message' => $message,
                'appointment_status' => $appointment_status,
                'source' => $source,
                'is_opd' => $is_opd,
                'is_ipd' => $is_ipd,
                'live_consult' => $live_constultant
            );
                $this->db->where('id',$appointment_id);
                $exec_update = $this->db->update('appointment',$data_update);

                if ($exec_update = TRUE) {
                    $data = array(
                        'ResponseCode' => '00',
                        'Status' => 'Success',
                        'Message' => 'Success Update appointment' 
                    );
                }else{
                    $data = array(
                        'ResponseCode' => '02',
                        'Status' => 'Failed',
                        'Message' => 'Failed Update appointment' 
                    );
                }

            }else{
                $data = array(
                    'ResponseCode' => '03',
                    'Status' => 'Failed',
                    'Message' => 'Not Found Data appointment', 
                );
            }
            
            return $data;

        // }else{
        //     return array('Status'=>'Failed',
        //             'Message'=>'User not found',
        //             'ResponseCode'=>'03'
        //     );
        // }
    }

    function delete_appointment($userid,$appointment_id,$secretkey){
        
        //cek signature
        if($secretkey != $this->secretkey_server){
            return array(
                'Status' => 'Failed',
                'Message' => 'Invalid Token',
                'ResponseCode' => '01' 
            );
        }

        $sql_user = "SELECT * FROM staff WHERE id = '$userid' AND is_active = '1' ";
        $exec_user = $this->db->query($sql_user)->row();

        if (isset($exec_user)) {

            $sql_appointment = $this->db->query("SELECT id FROM appointment WHERE id = '$appointment_id' ")->row();
            if (isset($sql_appointment)) {
                
                $this->db->query("DELETE FROM appointment WHERE id = '$appointment_id' ");
                $data = array(
                    'ResponseCode' => '00',
                    'Status' => 'Success',
                    'Message' => 'Success Delete Data', 
                );

            }else{
                $data = array(
                    'ResponseCode' => '03',
                    'Status' => 'Failed',
                    'Message' => 'Not Found Data appointment', 
                );
            }

            return $data;

        }else{
            return array('Status'=>'Failed',
                    'Message'=>'User not found',
                    'ResponseCode'=>'03'
            );
        }
        
    }


    
   



}

?>