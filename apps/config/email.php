<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: email.php
 *  Path: application/config/email.php
 *  Description: These are email configurations which used for send email.
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         09/05/2019              Created

 *
 *  Copyright (c) 2018 - Sab News Private Limited
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of Sab News Private Limited.
 *  The intellectual and technical concepts contained herein
 *  are proprietary to Sab News Private Limited and
 *  are considered trade secrets and/or confidential under Law
 *  Dissemination of this information or reproduction of this material,
 *  in whole or in part, is strictly forbidden unless prior written
 *  permission is obtained from Sab News Private Limited.
 *
 */
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = 587;
$config['smtp_user'] = 'xxxxxxxxxxxx@gmail.com';
$config['smtp_pass'] = 'xxxxxxxxxxxxxx';
$config['smtp_crypto'] = 'tls';
$config['mailtype'] = 'html';
$config['smtp_timeout'] = '10';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;