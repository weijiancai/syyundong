/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2015/3/8 20:37:51                            */
/*==============================================================*/


drop view  if exists v_activity_join_count;

drop view  if exists v_banner_images;

drop view  if exists v_choice_game;

drop view  if exists v_game_activity;

drop view  if exists v_game_join_count;

/*==============================================================*/
/* View: v_activity_join_count                                  */
/*==============================================================*/
create VIEW  v_activity_join_count

    as

    select activity_id, count(1) join_count from op_join_activity GROUP BY activity_id;

/*==============================================================*/
/* View: v_banner_images                                        */
/*==============================================================*/
create VIEW  v_banner_images

    as

    select v_game_activity.id, type, size1_url url, banner_desc from v_game_activity,db_images where v_game_activity.image = db_images.id and status=1 ORDER BY focus_count desc, join_count desc LIMIT 0, 6;

/*==============================================================*/
/* View: v_choice_game                                          */
/*==============================================================*/
create VIEW  v_choice_game

    as

    select;

/*==============================================================*/
/* View: v_game_activity                                        */
/*==============================================================*/
create VIEW  v_game_activity

    as

    SELECT
      id,
      name,
      sport_id,
      image,
      reg_begin_date,
      reg_end_date,
      start_date,
      end_date,
      limit_count,
      cost,
      province,
      address,
      input_user,
      input_date,
      'game' type,
      join_count,
      (select count(1) from op_focus where op_focus.source_id=db_game.id and sport_type=1) focus_count,
      (select count(1) from op_game_topic where op_game_topic.game_id=db_game.id) topic_count,
      (case when (now() < reg_end_date && join_count < limit_count) then 1 when (now() > reg_end_date || join_count = limit_count) then 2 when (now() >= start_date and now() < end_date) then 3 else 4 end) status
    FROM
      db_game, v_game_join_count where db_game.id = v_game_join_count.game_id
    UNION ALL
    SELECT
      id,
      name,
      sport_id,
      image,
      reg_begin_date,
      reg_end_date,
      start_date,
      end_date,
      limit_count,
      cost,
      province,
      address,
      input_user,
      input_date,
      'activity' type,
      join_count,
      (select count(1) from op_focus where op_focus.source_id=db_activity.id and sport_type=2) focus_count,
      0 topic_count,
      (case when (now() < reg_end_date or join_count < limit_count) then 1 when (now() > reg_end_date || join_count = limit_count) then 2 when (now() >= start_date and now() < end_date) then 3 else 4 end) status
    FROM    
      db_activity, v_activity_join_count where db_activity.id = v_activity_join_count.activity_id;

/*==============================================================*/
/* View: v_game_join_count                                      */
/*==============================================================*/
create VIEW  v_game_join_count

    as

    select game_id, count(1) join_count from op_join_game GROUP BY game_id;

