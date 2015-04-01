/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2015/4/1 22:48:58                            */
/*==============================================================*/


ALTER TABLE  db_activity DROP FOREIGN KEY FK_activity_sport_id;

ALTER TABLE  db_game DROP FOREIGN KEY FK_game_sport_id;

ALTER TABLE  db_venue DROP FOREIGN KEY FK_venue_sport_id;

ALTER TABLE  mt_field_option DROP FOREIGN KEY FK_fieldOption_fieldDefine_id;

ALTER TABLE  op_comment DROP FOREIGN KEY FK_comment_user_id;

ALTER TABLE  op_focus DROP FOREIGN KEY FK_focus_user_id;

ALTER TABLE  op_game_field DROP FOREIGN KEY FK_gameField_fieldDefine_id;

ALTER TABLE  op_game_field DROP FOREIGN KEY FK_gameField_game_id;

ALTER TABLE  op_game_news DROP FOREIGN KEY FK_gameNews_game_id;

ALTER TABLE  op_game_notice DROP FOREIGN KEY FK_gameNotice_game_id;

ALTER TABLE  op_game_score DROP FOREIGN KEY FK_gameScore_game_id;

ALTER TABLE  op_game_score DROP FOREIGN KEY FK_gameScore_user_id;

ALTER TABLE  op_game_topic DROP FOREIGN KEY FK_gameTopic_game_id;

ALTER TABLE  op_game_topic DROP FOREIGN KEY FK_gameTopic_user_id;

ALTER TABLE  op_game_topic_images DROP FOREIGN KEY FK_Reference_23;

ALTER TABLE  op_join_activity DROP FOREIGN KEY FK_joinActivity_activity_id;

ALTER TABLE  op_join_game DROP FOREIGN KEY FK_joinGame_game_Id;

ALTER TABLE  op_join_game DROP FOREIGN KEY FK_joinGame_user_id;

ALTER TABLE  op_join_game_field DROP FOREIGN KEY FK_joinGameField_fieldDefine_id;

ALTER TABLE  op_join_game_field DROP FOREIGN KEY FK_joinGameField_joinGame_id;

ALTER TABLE  op_message DROP FOREIGN KEY FK_message_user_id;

ALTER TABLE  op_user_friend DROP FOREIGN KEY FK_userFriend_user_friendId;

ALTER TABLE  op_user_friend DROP FOREIGN KEY FK_userFriend_user_userId;

drop view  if exists v_activity_join_count;

drop view  if exists v_banner_images;

drop view  if exists v_choice_game;

drop view  if exists v_doyen_user;

drop view  if exists v_game_activity;

drop view  if exists v_game_join_count;

drop view  if exists v_hot_activity;

drop view  if exists v_hot_game_ranking;

drop view  if exists v_recommend_venues;

drop view  if exists v_topic;

drop view  if exists v_topic_comment_count;

drop view  if exists v_user_topic_count;

drop table if exists db_activity;

drop table if exists db_game;

drop table if exists db_images;

drop table if exists db_user;

drop table if exists db_venue;

drop table if exists dz_sport;

drop table if exists mt_field_define;

drop table if exists mt_field_option;

drop table if exists op_comment;

drop table if exists op_focus;

drop table if exists op_game_field;

drop table if exists op_game_news;

drop table if exists op_game_notice;

drop table if exists op_game_score;

drop table if exists op_game_topic;

drop table if exists op_game_topic_images;

drop table if exists op_join_activity;

drop table if exists op_join_game;

drop table if exists op_join_game_field;

drop table if exists op_message;

drop table if exists op_user_friend;

/*==============================================================*/
/* Table: db_activity                                           */
/*==============================================================*/
create table db_activity
(
   id                   int not null auto_increment comment '活动ID',
   name                 varchar(40) not null comment '名称（标题）',
   sport_id             int not null comment '项目',
   image                int not null comment '图片',
   reg_begin_date       datetime not null comment '报名开始时间',
   reg_end_date         datetime not null comment '报名结束时间',
   start_date           datetime not null comment '开始时间',
   end_date             datetime not null comment '结束时间',
   limit_count          int not null comment '活动人数',
   join_need_info       varchar(32) comment '参加活动所需填写资料（1 真实姓名，2 性别，3 手机号码， 4 身份证号）',
   is_need_verify       char(1) not null comment '是否需要审核',
   cost_type            int(1) not null comment '费用类型（0 免费，1 收费）',
   cost                 decimal comment '费用',
   province             varchar(32) not null comment '省',
   city                 varchar(32) not null comment '市',
   region               varchar(32) not null comment '区',
   address              varchar(128) not null comment '地点',
   content              text comment '赛事介绍',
   input_date           datetime not null comment '录入时间',
   input_user           int not null comment '录入人',
   primary key (id)
);

/*==============================================================*/
/* Table: db_game                                               */
/*==============================================================*/
create table db_game
(
   id                   int not null auto_increment comment '赛事ID',
   name                 varchar(40) not null comment '名称（标题）',
   sport_id             int not null comment '比赛项目',
   image                int not null comment '图片',
   reg_begin_date       datetime not null comment '报名开始时间',
   reg_end_date         datetime not null comment '报名结束时间',
   start_date           datetime not null comment '开始时间',
   end_date             datetime not null comment '结束时间',
   limit_count          int not null comment '人数限制',
   cost                 decimal comment '报名费',
   province             varchar(16) not null comment '举办城市',
   address              varchar(128) not null comment '地点',
   sponor               varchar(128) not null comment '赛事发起方',
   phone                varchar(16) not null comment '联系方式',
   apply_name           varchar(16) not null comment '申请人姓名',
   apply_phone          varchar(16) not null comment '申请人电话',
   apply_email          varchar(32) not null comment '申请人邮箱',
   description          varchar(512) not null comment '推荐语',
   game_declare         text comment '参赛声明',
   content              text comment '赛事介绍',
   member_right         text comment '会员权益',
   aout_route           text comment '比赛路线',
   about_cost           text comment '关于费用',
   about_trip           text comment '行程安排',
   about_hotal          text comment '入住酒店',
   input_date           datetime not null comment '录入时间',
   input_user           int not null comment '录入人',
   is_verify            char(1) not null comment '是否已审核',
   verify_date          datetime comment '审核时间',
   primary key (id)
);

alter table db_game comment '赛事活动';

/*==============================================================*/
/* Table: db_images                                             */
/*==============================================================*/
create table db_images
(
   id                   int not null auto_increment comment '图片ID',
   local_url            varchar(128) not null comment '图片URL',
   banner_desc          varchar(64) comment 'banner描述',
   size1_url            varchar(128) comment '尺寸1URL（banner 505x355）',
   size2_url            varchar(128) comment '尺寸2URL',
   size3_url            varchar(128) comment '尺寸3URL',
   size4_url            varchar(128) comment '尺寸4URL',
   size5_url            varchar(128) comment '尺寸5URL',
   primary key (id)
);

alter table db_images comment '图片';

/*==============================================================*/
/* Table: db_user                                               */
/*==============================================================*/
create table db_user
(
   id                   int not null auto_increment comment '用户ID',
   name                 varchar(64) not null comment '姓名',
   user_head            int not null comment '用户头像',
   nick_name            char(10) comment '昵称',
   password             varchar(64) not null comment '密码',
   gender               char(1) not null comment '性别（F 女，M 男）',
   blood_type           char(2) comment '血型（A，B，AB，O，RH，MN，其它 ）',
   birthday             date comment '生日',
   company              varchar(64) comment '公司',
   certificate_type     varchar(10) comment '证件类型（身份证，军官证，学生证，护照）',
   certificate_num      varchar(64) comment '证件号码',
   high                 int comment '身高',
   weight               decimal comment '体重',
   mobile               varchar(16) comment '手机号码',
   email                varchar(64) comment '邮箱',
   postal_code          varchar(16) comment '邮编',
   address              varchar(128) comment '通讯地址',
   signature            varchar(64) comment '个性签名',
   interest             varchar(512) comment '运动喜好（多值，逗号分隔）',
   verify_code          varchar(10) comment '验证码',
   input_date           datetime not null comment '录入时间',
   primary key (id)
);

alter table db_user comment '用户';

/*==============================================================*/
/* Table: db_venue                                              */
/*==============================================================*/
create table db_venue
(
   id                   int not null auto_increment comment '场馆ID',
   name                 varchar(64) not null comment '场馆名称',
   image                int not null comment '图片',
   sport_id             int not null comment '运动项目',
   province             varchar(32) not null comment '省',
   city                 varchar(32) not null comment '市',
   region               varchar(32) not null comment '区',
   address              varchar(128) not null comment '地点',
   phone                varchar(32) comment '电话',
   person_cost          int not null comment '人均',
   input_date           datetime not null comment '录入时间',
   input_user           int not null comment '录入人',
   primary key (id)
);

alter table db_venue comment '场馆';

/*==============================================================*/
/* Table: dz_sport                                              */
/*==============================================================*/
create table dz_sport
(
   id                   int not null auto_increment comment '项目ID',
   name                 varchar(64) not null comment '项目名称',
   sport_type           int(1) not null comment '项目类型（0 赛事/活动/场馆，1 赛事，2 活动，3 场馆）',
   level                int(1) comment '级别',
   pid                  int not null comment '父项目ID',
   input_date           datetime not null comment '录入时间',
   input_user           int not null comment '录入人',
   primary key (id)
);

alter table dz_sport comment '赛事活动项目';

/*==============================================================*/
/* Table: mt_field_define                                       */
/*==============================================================*/
create table mt_field_define
(
   id                   int not null auto_increment comment '字段ID',
   name                 varchar(64) not null comment '名称',
   code                 varchar(64) not null comment '英文名',
   filed_type           int(1) not null comment '字段类型（1 text，2 textarea，3 dropdown，4 email，5 mobile）',
   regex                varchar(64) comment '正则式',
   tip                  varchar(64) comment '提示信息',
   required             char(1) not null comment '是否必须',
   memo                 varchar(128) comment '备注',
   primary key (id)
);

alter table mt_field_define comment '字段定义';

/*==============================================================*/
/* Table: mt_field_option                                       */
/*==============================================================*/
create table mt_field_option
(
   field_id             int comment '字段ID',
   name                 varchar(64) not null comment '名称',
   value                varchar(64) not null comment '值',
   checked              char(1) not null comment '默认选中'
);

alter table mt_field_option comment '字段选项';

/*==============================================================*/
/* Table: op_comment                                            */
/*==============================================================*/
create table op_comment
(
   id                   int not null auto_increment comment '评论ID',
   content              varchar(128) not null comment '评论内容',
   user_id              int not null comment '用户ID',
   reply_to             int not null comment '回复ID',
   source_id            int not null comment '来源ID',
   source_type          int(1) not null comment '来源类型（1 赛事，2 活动，3 场馆，4 话题）',
   primary key (id)
);

alter table op_comment comment '评论';

/*==============================================================*/
/* Table: op_focus                                              */
/*==============================================================*/
create table op_focus
(
   id                   int not null auto_increment comment '评论ID',
   user_id              int not null comment '用户ID',
   source_id            int not null comment '来源ID',
   sport_type           int(1) not null comment '运动项目（0 赛事/活动/场馆，1 赛事，2 活动，3 场馆）',
   primary key (id)
);

alter table op_focus comment '关注';

/*==============================================================*/
/* Table: op_game_field                                         */
/*==============================================================*/
create table op_game_field
(
   game_id              int not null comment '赛事ID',
   field_id             int not null comment '字段ID',
   sort_num             int comment '排序号',
   primary key (game_id, field_id)
);

alter table op_game_field comment '赛事字段';

/*==============================================================*/
/* Table: op_game_news                                          */
/*==============================================================*/
create table op_game_news
(
   id                   int not null auto_increment comment '新闻ID',
   game_id              int comment '赛事ID',
   content              varchar(1024) not null comment '新闻内容',
   input_date           datetime not null comment '录入时间',
   input_user           int not null comment '录入人',
   primary key (id)
);

alter table op_game_news comment '赛事新闻';

/*==============================================================*/
/* Table: op_game_notice                                        */
/*==============================================================*/
create table op_game_notice
(
   id                   int not null auto_increment comment '公告ID',
   game_id              int comment '赛事ID',
   content              varchar(1024) not null comment '公告内容',
   input_date           datetime not null comment '录入时间',
   input_user           int not null comment '录入人',
   primary key (id)
);

alter table op_game_notice comment '赛事公告';

/*==============================================================*/
/* Table: op_game_score                                         */
/*==============================================================*/
create table op_game_score
(
   game_id              int comment '赛事活动ID',
   user_id              int comment '用户ID',
   game_number          int comment '参赛号码',
   score                decimal comment '分数'
);

alter table op_game_score comment '比赛成绩';

/*==============================================================*/
/* Table: op_game_topic                                         */
/*==============================================================*/
create table op_game_topic
(
   id                   int not null auto_increment comment '话题ID',
   game_id              int comment '赛事ID',
   user_id              int comment '用户ID',
   content              varchar(512) not null comment '话题内容',
   laud_count           int comment '点赞数',
   input_date           datetime not null comment '录入时间',
   primary key (id)
);

alter table op_game_topic comment '赛事话题';

/*==============================================================*/
/* Table: op_game_topic_images                                  */
/*==============================================================*/
create table op_game_topic_images
(
   topic_id             int comment '话题ID',
   image_id             int not null comment '图片ID'
);

alter table op_game_topic_images comment '话题图片';

/*==============================================================*/
/* Table: op_join_activity                                      */
/*==============================================================*/
create table op_join_activity
(
   join_id              int not null auto_increment comment '报名iD',
   activity_id          int not null comment '活动ID',
   user_id              int comment '用户ID',
   true_name            varchar(32) comment '真实姓名',
   gender               char(1) comment '性别（F 女，M 男）',
   mobile               varchar(16) comment '手机',
   certificate_num      varchar(64) comment '身份证号',
   verify_state         int(1) not null comment '审核状态（0 待审核，1 通过，2 不通过）',
   input_date           datetime not null comment '录入时间',
   verify_date          datetime comment '审核时间',
   primary key (join_id)
);

alter table op_join_activity comment '参加活动';

/*==============================================================*/
/* Table: op_join_game                                          */
/*==============================================================*/
create table op_join_game
(
   join_Id              int not null auto_increment comment '报名ID',
   game_id              int comment '赛事ID',
   user_id              int comment '用户ID',
   verify_state         int(1) not null comment '审核状态（0 待审核，1 通过，2 不通过）',
   input_date           datetime not null comment '录入时间',
   verify_date          datetime comment '审核时间',
   primary key (join_Id)
);

alter table op_join_game comment '参加比赛';

/*==============================================================*/
/* Table: op_join_game_field                                    */
/*==============================================================*/
create table op_join_game_field
(
   join_Id              int comment '报名ID',
   field_id             int not null comment '字段ID',
   field_value          varchar(1024) comment '字段值'
);

/*==============================================================*/
/* Table: op_message                                            */
/*==============================================================*/
create table op_message
(
   id                   int not null auto_increment comment '消息ID',
   user_id              int comment '用户ID',
   title                varchar(64) not null comment '标题',
   content              varchar(1024) comment '内容',
   source_id            int not null comment '来源ID',
   source_type          int(1) not null comment '来源类型（1 赛事，2 活动，3 场馆，4 话题）',
   primary key (id)
);

alter table op_message comment '消息';

/*==============================================================*/
/* Table: op_user_friend                                        */
/*==============================================================*/
create table op_user_friend
(
   user_id              int not null comment '用户ID',
   friend_id            int not null comment '赛友ID',
   primary key (user_id, friend_id)
);

alter table op_user_friend comment '赛友';

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

    SELECT
      v_game_activity.id,
      type,
      size1_url url,
      banner_desc
    FROM v_game_activity, db_images
    WHERE v_game_activity.image = db_images.id AND status = 1 AND type = 'game'
    ORDER BY focus_count DESC, join_count DESC
    LIMIT 0, 6;

/*==============================================================*/
/* View: v_choice_game                                          */
/*==============================================================*/
create VIEW  v_choice_game

    as

    select 
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
    type,
    join_count,
    focus_count,
    topic_count,
    status
     from v_game_activity where (status=1 or status=2 or status=3) and type='game' ORDER BY focus_count desc, join_count;

/*==============================================================*/
/* View: v_doyen_user                                           */
/*==============================================================*/
create VIEW  v_doyen_user

    as

    SELECT
      db_user.id,
      name
    FROM db_user, v_user_topic_count
    WHERE db_user.id = v_user_topic_count.user_id
    ORDER BY topic_count DESC
    LIMIT 0, 8;

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
      db_game left join v_game_join_count on (db_game.id = v_game_join_count.game_id) where is_verify='T'
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
      db_activity left join v_activity_join_count on (db_activity.id = v_activity_join_count.activity_id);

/*==============================================================*/
/* View: v_game_join_count                                      */
/*==============================================================*/
create VIEW  v_game_join_count

    as

    select game_id, count(1) join_count from op_join_game GROUP BY game_id;

/*==============================================================*/
/* View: v_hot_activity                                         */
/*==============================================================*/
create VIEW  v_hot_activity

    as

    select
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
      type,
      join_count,
      focus_count,
      topic_count,
      status,
      (select local_url from db_images where db_images.id = input_user) user_image
    from v_game_activity where (status=1 or status=2 or status=3) and type='activity' ORDER BY join_count desc, focus_count desc limit 0, 6;

/*==============================================================*/
/* View: v_hot_game_ranking                                     */
/*==============================================================*/
create VIEW  v_hot_game_ranking

    as

    select id, name from v_game_activity where type='game' ORDER BY focus_count desc, join_count LIMIT 0, 10;

/*==============================================================*/
/* View: v_recommend_venues                                     */
/*==============================================================*/
create VIEW  v_recommend_venues

    as

    select;

/*==============================================================*/
/* View: v_topic                                                */
/*==============================================================*/
create VIEW  v_topic

    as

    SELECT
      op_game_topic.id,
      op_game_topic.game_id,
      op_game_topic.user_id,
      op_game_topic.content,
      op_game_topic.laud_count,
      op_game_topic.input_date,
      comment_count,
      (select name from db_user where db_user.id = op_game_topic.user_id) user_name,
      (select name from db_game where db_game.id = op_game_topic.game_id) game_name
    FROM
      op_game_topic left join v_topic_comment_count on (op_game_topic.id = v_topic_comment_count.topic_id);

/*==============================================================*/
/* View: v_topic_comment_count                                  */
/*==============================================================*/
create VIEW  v_topic_comment_count

    as

    select source_id topic_id, count(1) comment_count from op_comment where source_type=4 group by source_id;

/*==============================================================*/
/* View: v_user_topic_count                                     */
/*==============================================================*/
create VIEW  v_user_topic_count

    as

    select user_id, count(1) topic_count from op_game_topic GROUP BY user_id;

alter table db_activity add constraint FK_activity_sport_id foreign key (sport_id)
      references dz_sport (id) on delete restrict on update restrict;

alter table db_game add constraint FK_game_sport_id foreign key (sport_id)
      references dz_sport (id) on delete restrict on update restrict;

alter table db_venue add constraint FK_venue_sport_id foreign key (sport_id)
      references dz_sport (id) on delete restrict on update restrict;

alter table mt_field_option add constraint FK_fieldOption_fieldDefine_id foreign key (field_id)
      references mt_field_define (id) on delete cascade on update cascade;

alter table op_comment add constraint FK_comment_user_id foreign key (user_id)
      references db_user (id) on delete cascade on update cascade;

alter table op_focus add constraint FK_focus_user_id foreign key (user_id)
      references db_user (id) on delete cascade on update cascade;

alter table op_game_field add constraint FK_gameField_fieldDefine_id foreign key (field_id)
      references mt_field_define (id) on delete cascade on update cascade;

alter table op_game_field add constraint FK_gameField_game_id foreign key (game_id)
      references db_game (id) on delete cascade on update cascade;

alter table op_game_news add constraint FK_gameNews_game_id foreign key (game_id)
      references db_game (id) on delete cascade on update cascade;

alter table op_game_notice add constraint FK_gameNotice_game_id foreign key (game_id)
      references db_game (id) on delete cascade on update cascade;

alter table op_game_score add constraint FK_gameScore_game_id foreign key (game_id)
      references db_game (id) on delete cascade on update cascade;

alter table op_game_score add constraint FK_gameScore_user_id foreign key (user_id)
      references db_user (id) on delete restrict on update restrict;

alter table op_game_topic add constraint FK_gameTopic_game_id foreign key (game_id)
      references db_game (id) on delete cascade on update cascade;

alter table op_game_topic add constraint FK_gameTopic_user_id foreign key (user_id)
      references db_user (id) on delete restrict on update restrict;

alter table op_game_topic_images add constraint FK_Reference_23 foreign key (topic_id)
      references op_game_topic (id) on delete restrict on update restrict;

alter table op_join_activity add constraint FK_joinActivity_activity_id foreign key (activity_id)
      references db_activity (id) on delete cascade on update cascade;

alter table op_join_game add constraint FK_joinGame_game_Id foreign key (game_id)
      references db_game (id) on delete cascade on update cascade;

alter table op_join_game add constraint FK_joinGame_user_id foreign key (user_id)
      references db_user (id) on delete restrict on update restrict;

alter table op_join_game_field add constraint FK_joinGameField_fieldDefine_id foreign key (field_id)
      references mt_field_define (id) on delete cascade on update cascade;

alter table op_join_game_field add constraint FK_joinGameField_joinGame_id foreign key (join_Id)
      references op_join_game (join_Id) on delete cascade on update cascade;

alter table op_message add constraint FK_message_user_id foreign key (user_id)
      references db_user (id) on delete cascade on update cascade;

alter table op_user_friend add constraint FK_userFriend_user_friendId foreign key (friend_id)
      references db_user (id) on delete restrict on update restrict;

alter table op_user_friend add constraint FK_userFriend_user_userId foreign key (user_id)
      references db_user (id) on delete cascade on update cascade;

