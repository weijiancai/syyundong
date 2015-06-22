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
