v_choice_game
select
id,
name,
sport_sid,
start_date,
end_date,
limit_count,
cost,
game_declare,
city,
region,
address,
is_verify,
type,
join_count,
focus_count,
topic_count,
status,
image
from
v_game_activity
where
(status = 1
or status = 2
or status = 3)
and type = 'game'
order by
focus_count DESC,
join_count ASC;

v_game_activity:筹备中
drop view v_game_activity;
create view v_game_activity
as
SELECT
  id,
  name,
  sport_id,
  sport_sid,
  (SELECT local_url FROM db_images WHERE id = db_game.image) image,
  reg_begin_date,
  reg_end_date,
  start_date,
  end_date,
  limit_count,
  game_declare,
  description,
  cost,
  province,
  city,
  region,
  address,
  sponsor,
  content,
  ''interest_count,
  input_user,
  input_date,
  is_verify,
  'game' type,
  ifnull(join_count, 0) join_count,
  limit_count-join_count remaining,
  (SELECT name FROM dz_sport WHERE id = sport_sid) sport_name,
  (select count(1) from op_focus where op_focus.source_id=db_game.id and source_type=1) focus_count,
  (select count(1) from op_game_topic where op_game_topic.game_id=db_game.id) topic_count,
  (case
	when (now() < reg_begin_date) then 5
	 when (now() > reg_begin_date and now() < reg_end_date and ifnull(join_count, 0) <= limit_count) then 1
   when ((now() < start_date)or(now() > reg_end_date and  ifnull(join_count, 0) > limit_count)  and now() < start_date) then 2
   when (now() >= start_date and now() < end_date) then 3 else 4 end) status
FROM
  db_game left join v_game_join_count on (db_game.id = v_game_join_count.game_id) where is_verify='T'
UNION ALL
SELECT
  id,
  name,
  sport_id,
  ''sport_sid,
  (SELECT local_url FROM db_images WHERE id = db_activity.image) image,
  reg_begin_date,
  reg_end_date,
  start_date,
  end_date,
  limit_count,
  ''game_declare,
  ''description,
  cost,
  province,
  city,
  region,
  address,
  ''sponsor,
  content,
  interest_count,
  input_user,
  input_date,
  is_verify,
  'activity' type,
  ifnull(join_count, 0) join_count,
  limit_count-join_count remaining,
  (SELECT name FROM dz_sport WHERE id = sport_sid) sport_name,
  (select count(1) from op_focus where op_focus.source_id=db_activity.id and source_type=2) focus_count,
  (select count(1) from op_comment where op_comment.source_id=db_activity.id and source_type=2)  topic_count,
  (case
		when (now() < reg_begin_date) then 5
	 when (now() > reg_begin_date and now() < reg_end_date and ifnull(join_count, 0) <= limit_count) then 1
   when ((now() < start_date)or(now() > reg_end_date and  ifnull(join_count, 0) > limit_count)  and now() < start_date) then 2
   when (now() >= start_date and now() < end_date) then 3 else 4 end) status
FROM
  db_activity left join v_activity_join_count on (db_activity.id = v_activity_join_count.activity_id) where is_verify='T'


