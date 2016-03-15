<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/27/16
 * Time: 8:50 AM
 */

namespace ZayconWhatCounts;


class Campaign
{
    private $list_id;
    private $template_id;
    private $format;
    private $subject;
    private $segmentation_id;
    private $seed_list_id;
    private $supression_list;
    private $data_macro_id;
    private $alias;
    private $limit;
    private $vmta;
    private $ab_definition_id;
    private $deployed_by_email;

    // Boolean values
    private $rss;
    private $seed_delivery;
    private $send_notification;
    private $no_end_date;
    private $return_task_id;
    private $task_id;

    private $start_month;
    private $start_day;
    private $start_year;
    private $start_hour;
    private $start_minute;
    private $end_month;
    private $end_day;
    private $end_year;
    private $workflow_send_time;
    private $repeat_frequency;

    private $fillin_name0;
    private $fillin_value0;
    private $fillin_name1;
    private $fillin_value1;
    private $fillin_name2;
    private $fillin_value2;
    private $fillin_name3;
    private $fillin_value3;
    private $fillin_name4;
    private $fillin_value4;
    private $fillin_name5;
    private $fillin_value5;
    private $fillin_name6;
    private $fillin_value6;
    private $fillin_name7;
    private $fillin_value7;
    private $fillin_name8;
    private $fillin_value8;
    private $fillin_name9;
    private $fillin_value9;

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->list_id;
    }

    /**
     * @param mixed $list_id
     * @return Campaign
     */
    public function setListId($list_id)
    {
        $this->list_id = $list_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @param mixed $template_id
     * @return Campaign
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     * @return Campaign
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     *
     * @return Campaign
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSegmentationId()
    {
        return $this->segmentation_id;
    }

    /**
     * @param mixed $segmentation_id
     * @return Campaign
     */
    public function setSegmentationId($segmentation_id)
    {
        $this->segmentation_id = $segmentation_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeedListId()
    {
        return $this->seed_list_id;
    }

    /**
     * @param mixed $seed_list_id
     * @return Campaign
     */
    public function setSeedListId($seed_list_id)
    {
        $this->seed_list_id = $seed_list_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSupressionList()
    {
        return $this->supression_list;
    }

    /**
     * @param mixed $supression_list
     * @return Campaign
     */
    public function setSupressionList($supression_list)
    {
        $this->supression_list = $supression_list;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataMacroId()
    {
        return $this->data_macro_id;
    }

    /**
     * @param mixed $data_macro_id
     * @return Campaign
     */
    public function setDataMacroId($data_macro_id)
    {
        $this->data_macro_id = $data_macro_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param mixed $alias
     * @return Campaign
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     * @return Campaign
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVmta()
    {
        return $this->vmta;
    }

    /**
     * @param mixed $vmta
     *
     * @return Campaign
     */
    public function setVmta($vmta)
    {
        $this->vmta = $vmta;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAbDefinitionId()
    {
        return $this->ab_definition_id;
    }

    /**
     * @param mixed $ab_definition_id
     *
     * @return Campaign
     */
    public function setAbDefinitionId($ab_definition_id)
    {
        $this->ab_definition_id = $ab_definition_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeployedByEmail()
    {
        return $this->deployed_by_email;
    }

    /**
     * @param mixed $deployed_by_email
     *
     * @return Campaign
     */
    public function setDeployedByEmail($deployed_by_email)
    {
        $this->deployed_by_email = $deployed_by_email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturnTaskId()
    {
        return $this->return_task_id;
    }

    /**
     * @param mixed $return_task_id
     *
     * @return Campaign
     */
    public function setReturnTaskId($return_task_id)
    {
        $this->return_task_id = $return_task_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->task_id;
    }

    /**
     * @param mixed $task_id
     *
     * @return Campaign
     */
    public function setTaskId($task_id)
    {
        $this->task_id = $task_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRss()
    {
        return $this->rss;
    }

    /**
     * @param mixed $rss
     * @return Campaign
     */
    public function setRss($rss)
    {
        $this->rss = $rss;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeedDelivery()
    {
        return $this->seed_delivery;
    }

    /**
     * @param mixed $seed_delivery
     * @return Campaign
     */
    public function setSeedDelivery($seed_delivery)
    {
        $this->seed_delivery = $seed_delivery;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSendNotification()
    {
        return $this->send_notification;
    }

    /**
     * @param mixed $send_notification
     * @return Campaign
     */
    public function setSendNotification($send_notification)
    {
        $this->send_notification = $send_notification;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNoEndDate()
    {
        return $this->no_end_date;
    }

    /**
     * @param mixed $no_end_date
     * @return Campaign
     */
    public function setNoEndDate($no_end_date)
    {
        $this->no_end_date = $no_end_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartMonth()
    {
        return $this->start_month;
    }

    /**
     * @param mixed $start_month
     * @return Campaign
     */
    public function setStartMonth($start_month)
    {
        $this->start_month = $start_month;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartDay()
    {
        return $this->start_day;
    }

    /**
     * @param mixed $start_day
     * @return Campaign
     */
    public function setStartDay($start_day)
    {
        $this->start_day = $start_day;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartYear()
    {
        return $this->start_year;
    }

    /**
     * @param mixed $start_year
     * @return Campaign
     */
    public function setStartYear($start_year)
    {
        $this->start_year = $start_year;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartHour()
    {
        return $this->start_hour;
    }

    /**
     * @param mixed $start_hour
     * @return Campaign
     */
    public function setStartHour($start_hour)
    {
        $this->start_hour = $start_hour;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartMinute()
    {
        return $this->start_minute;
    }

    /**
     * @param mixed $start_minute
     * @return Campaign
     */
    public function setStartMinute($start_minute)
    {
        $this->start_minute = $start_minute;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndMonth()
    {
        return $this->end_month;
    }

    /**
     * @param mixed $end_month
     * @return Campaign
     */
    public function setEndMonth($end_month)
    {
        $this->end_month = $end_month;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndDay()
    {
        return $this->end_day;
    }

    /**
     * @param mixed $end_day
     * @return Campaign
     */
    public function setEndDay($end_day)
    {
        $this->end_day = $end_day;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndYear()
    {
        return $this->end_year;
    }

    /**
     * @param mixed $end_year
     * @return Campaign
     */
    public function setEndYear($end_year)
    {
        $this->end_year = $end_year;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkflowSendTime()
    {
        return $this->workflow_send_time;
    }

    /**
     * @param mixed $workflow_send_time
     * @return Campaign
     */
    public function setWorkflowSendTime($workflow_send_time)
    {
        $this->workflow_send_time = $workflow_send_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRepeatFrequency()
    {
        return $this->repeat_frequency;
    }

    /**
     * @param mixed $repeat_frequency
     * @return Campaign
     */
    public function setRepeatFrequency($repeat_frequency)
    {
        $this->repeat_frequency = $repeat_frequency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName0()
    {
        return $this->fillin_name0;
    }

    /**
     * @param mixed $fillin_name0
     * @return Campaign
     */
    public function setFillinName0($fillin_name0)
    {
        $this->fillin_name0 = $fillin_name0;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue0()
    {
        return $this->fillin_value0;
    }

    /**
     * @param mixed $fillin_value0
     * @return Campaign
     */
    public function setFillinValue0($fillin_value0)
    {
        $this->fillin_value0 = $fillin_value0;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName1()
    {
        return $this->fillin_name1;
    }

    /**
     * @param mixed $fillin_name1
     * @return Campaign
     */
    public function setFillinName1($fillin_name1)
    {
        $this->fillin_name1 = $fillin_name1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue1()
    {
        return $this->fillin_value1;
    }

    /**
     * @param mixed $fillin_value1
     * @return Campaign
     */
    public function setFillinValue1($fillin_value1)
    {
        $this->fillin_value1 = $fillin_value1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName2()
    {
        return $this->fillin_name2;
    }

    /**
     * @param mixed $fillin_name2
     * @return Campaign
     */
    public function setFillinName2($fillin_name2)
    {
        $this->fillin_name2 = $fillin_name2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue2()
    {
        return $this->fillin_value2;
    }

    /**
     * @param mixed $fillin_value2
     * @return Campaign
     */
    public function setFillinValue2($fillin_value2)
    {
        $this->fillin_value2 = $fillin_value2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName3()
    {
        return $this->fillin_name3;
    }

    /**
     * @param mixed $fillin_name3
     * @return Campaign
     */
    public function setFillinName3($fillin_name3)
    {
        $this->fillin_name3 = $fillin_name3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue3()
    {
        return $this->fillin_value3;
    }

    /**
     * @param mixed $fillin_value3
     * @return Campaign
     */
    public function setFillinValue3($fillin_value3)
    {
        $this->fillin_value3 = $fillin_value3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName4()
    {
        return $this->fillin_name4;
    }

    /**
     * @param mixed $fillin_name4
     * @return Campaign
     */
    public function setFillinName4($fillin_name4)
    {
        $this->fillin_name4 = $fillin_name4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue4()
    {
        return $this->fillin_value4;
    }

    /**
     * @param mixed $fillin_value4
     * @return Campaign
     */
    public function setFillinValue4($fillin_value4)
    {
        $this->fillin_value4 = $fillin_value4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName5()
    {
        return $this->fillin_name5;
    }

    /**
     * @param mixed $fillin_name5
     * @return Campaign
     */
    public function setFillinName5($fillin_name5)
    {
        $this->fillin_name5 = $fillin_name5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue5()
    {
        return $this->fillin_value5;
    }

    /**
     * @param mixed $fillin_value5
     * @return Campaign
     */
    public function setFillinValue5($fillin_value5)
    {
        $this->fillin_value5 = $fillin_value5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName6()
    {
        return $this->fillin_name6;
    }

    /**
     * @param mixed $fillin_name6
     * @return Campaign
     */
    public function setFillinName6($fillin_name6)
    {
        $this->fillin_name6 = $fillin_name6;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue6()
    {
        return $this->fillin_value6;
    }

    /**
     * @param mixed $fillin_value6
     * @return Campaign
     */
    public function setFillinValue6($fillin_value6)
    {
        $this->fillin_value6 = $fillin_value6;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName7()
    {
        return $this->fillin_name7;
    }

    /**
     * @param mixed $fillin_name7
     * @return Campaign
     */
    public function setFillinName7($fillin_name7)
    {
        $this->fillin_name7 = $fillin_name7;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue7()
    {
        return $this->fillin_value7;
    }

    /**
     * @param mixed $fillin_value7
     * @return Campaign
     */
    public function setFillinValue7($fillin_value7)
    {
        $this->fillin_value7 = $fillin_value7;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName8()
    {
        return $this->fillin_name8;
    }

    /**
     * @param mixed $fillin_name8
     * @return Campaign
     */
    public function setFillinName8($fillin_name8)
    {
        $this->fillin_name8 = $fillin_name8;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue8()
    {
        return $this->fillin_value8;
    }

    /**
     * @param mixed $fillin_value8
     * @return Campaign
     */
    public function setFillinValue8($fillin_value8)
    {
        $this->fillin_value8 = $fillin_value8;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinName9()
    {
        return $this->fillin_name9;
    }

    /**
     * @param mixed $fillin_name9
     * @return Campaign
     */
    public function setFillinName9($fillin_name9)
    {
        $this->fillin_name9 = $fillin_name9;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillinValue9()
    {
        return $this->fillin_value9;
    }

    /**
     * @param mixed $fillin_value9
     * @return Campaign
     */
    public function setFillinValue9($fillin_value9)
    {
        $this->fillin_value9 = $fillin_value9;
        return $this;
    }

}