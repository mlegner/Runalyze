/* 18.10.2015 - drop 'types' flag for sport */
ALTER TABLE `runalyze_sport` DROP `types`;

/* 15.11.2015 - add 'time' column to swimdata, remove from trackdata */
ALTER TABLE `runalyze_swimdata` ADD `time` longtext AFTER `activityid`;
UPDATE runalyze_swimdata sw LEFT JOIN runalyze_trackdata tr ON sw.activityid=tr.activityid SET sw.time=tr.time;
UPDATE runalyze_trackdata tr LEFT JOIN runalyze_swimdata sw ON tr.activityid=sw.activityid SET tr.time='' WHERE tr.activityid=sw.activityid;
/* TODO - Check if cadence is needed in _trackdata */