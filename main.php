<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Initially developped for :
 * Université de Cergy-Pontoise
 * 33, boulevard du Port
 * 95011 Cergy-Pontoise cedex
 * FRANCE
 *
 * Check whether or not cron was successfully completed.
 *
 * @package   local_checkcronsuccess
 * @copyright 2017 Laurent Guillet <laurent.guillet@u-cergy.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * File : main.php
 * Check whether cron execution was successful.
 */

define('CLI_SCRIPT', true);
require_once(__DIR__.'/../../config.php');

global $DB;

$hourago = time() - 900;

$forumtask = $DB->get_record('task_scheduled', array('classname' => '\mod_forum\task\cron_task'));

if ($forumtask->lastruntime < $hourago) {

    $to = "s.ingenierie.logicielle@ml.u-cergy.fr";
    $subject = "Erreur dans le cron";
    $message = utf8_decode("Cela fait plus de 15 minutes que les mails n'ont pas été envoyés."
            . " Le cron peut ne pas fonctionner.");

    mail($to, $subject, $message);
}

