CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "permissions"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "guard_name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "permissions_name_guard_name_unique" on "permissions"(
  "name",
  "guard_name"
);
CREATE TABLE IF NOT EXISTS "roles"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "guard_name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "roles_name_guard_name_unique" on "roles"(
  "name",
  "guard_name"
);
CREATE TABLE IF NOT EXISTS "model_has_permissions"(
  "permission_id" integer not null,
  "model_type" varchar not null,
  "model_id" integer not null,
  foreign key("permission_id") references "permissions"("id") on delete cascade,
  primary key("permission_id", "model_id", "model_type")
);
CREATE INDEX "model_has_permissions_model_id_model_type_index" on "model_has_permissions"(
  "model_id",
  "model_type"
);
CREATE TABLE IF NOT EXISTS "model_has_roles"(
  "role_id" integer not null,
  "model_type" varchar not null,
  "model_id" integer not null,
  foreign key("role_id") references "roles"("id") on delete cascade,
  primary key("role_id", "model_id", "model_type")
);
CREATE INDEX "model_has_roles_model_id_model_type_index" on "model_has_roles"(
  "model_id",
  "model_type"
);
CREATE TABLE IF NOT EXISTS "role_has_permissions"(
  "permission_id" integer not null,
  "role_id" integer not null,
  foreign key("permission_id") references "permissions"("id") on delete cascade,
  foreign key("role_id") references "roles"("id") on delete cascade,
  primary key("permission_id", "role_id")
);
CREATE TABLE IF NOT EXISTS "translated_notices"(
  "id" integer primary key autoincrement not null,
  "language" varchar not null,
  "content" text,
  "enable_auto_translation" tinyint(1) not null default '1',
  "notice_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "reviews"(
  "id" integer primary key autoincrement not null,
  "content" text not null,
  "rating" integer not null default '0',
  "player_id" integer not null,
  "reviewer_user_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("player_id") references "players"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "translated_pages"(
  "id" integer primary key autoincrement not null,
  "content" text,
  "language" varchar not null,
  "enable_auto_translation" tinyint(1) not null,
  "page_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("page_id") references "pages"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "attendees"(
  "id" integer primary key autoincrement not null,
  "is_commitment_fulfilled" varchar,
  "player_id" integer not null,
  "event_id" integer not null,
  foreign key("player_id") references "players"("id"),
  foreign key("event_id") references "events"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "issues"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "description" text not null,
  "screenshots" text,
  "user_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  "solved_at" datetime,
  foreign key("user_id") references "users"("id")
);
CREATE INDEX "comments_reviewer_user_id_index" on "reviews"(
  "reviewer_user_id"
);
CREATE TABLE IF NOT EXISTS "respondents"(
  "id" integer primary key autoincrement not null,
  "agreement_id" integer not null,
  "player_id" integer not null,
  "value" varchar,
  foreign key("agreement_id") references "agreements"("id") on delete cascade,
  foreign key("player_id") references "players"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "telescope_entries"(
  "sequence" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "batch_id" varchar not null,
  "family_hash" varchar,
  "should_display_on_index" tinyint(1) not null default '1',
  "type" varchar not null,
  "content" text not null,
  "created_at" datetime
);
CREATE UNIQUE INDEX "telescope_entries_uuid_unique" on "telescope_entries"(
  "uuid"
);
CREATE INDEX "telescope_entries_batch_id_index" on "telescope_entries"(
  "batch_id"
);
CREATE INDEX "telescope_entries_family_hash_index" on "telescope_entries"(
  "family_hash"
);
CREATE INDEX "telescope_entries_created_at_index" on "telescope_entries"(
  "created_at"
);
CREATE INDEX "telescope_entries_type_should_display_on_index_index" on "telescope_entries"(
  "type",
  "should_display_on_index"
);
CREATE TABLE IF NOT EXISTS "telescope_entries_tags"(
  "entry_uuid" varchar not null,
  "tag" varchar not null,
  foreign key("entry_uuid") references "telescope_entries"("uuid") on delete cascade,
  primary key("entry_uuid", "tag")
);
CREATE INDEX "telescope_entries_tags_tag_index" on "telescope_entries_tags"(
  "tag"
);
CREATE TABLE IF NOT EXISTS "telescope_monitoring"(
  "tag" varchar not null,
  primary key("tag")
);
CREATE TABLE IF NOT EXISTS "event_event_category"(
  "event_id" integer not null,
  "event_category_id" integer not null,
  foreign key("event_id") references "events"("id") on delete cascade,
  foreign key("event_category_id") references "event_categories"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "alliances"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "acronym" varchar not null,
  "state" varchar not null,
  "domain" varchar not null,
  "deleted_at" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "alliances_name_unique" on "alliances"("name");
CREATE UNIQUE INDEX "alliances_acronym_unique" on "alliances"("acronym");
CREATE UNIQUE INDEX "alliances_domain_unique" on "alliances"("domain");
CREATE TABLE IF NOT EXISTS "players"(
  "id" integer primary key autoincrement not null,
  "nickname" varchar not null,
  "rating" integer not null,
  "in_game_id" varchar not null,
  "rank" integer not null,
  "deleted_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  "background" text,
  "translated_nickname" varchar,
  "alliance_id" integer default '1',
  foreign key("alliance_id") references "alliances"("id") on delete set null
);
CREATE UNIQUE INDEX "players_in_game_id_unique" on "players"("in_game_id");
CREATE INDEX "players_nickname_index" on "players"("nickname");
CREATE INDEX "players_translated_nickname_index" on "players"(
  "translated_nickname"
);
CREATE TABLE IF NOT EXISTS "agreements"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "options" text not null,
  "alliance_id" integer not null default '1',
  foreign key("alliance_id") references "alliances"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "internal_notes"(
  "id" integer primary key autoincrement not null,
  "content" text not null,
  "created_at" datetime,
  "updated_at" datetime,
  "alliance_id" integer not null default '1',
  foreign key("alliance_id") references "alliances"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "player_maps"(
  "id" integer primary key autoincrement not null,
  "coordinate_position" integer not null,
  "player_id" integer not null,
  "is_correct" tinyint(1) not null default '0',
  "alliance_id" integer not null default '1',
  foreign key("player_id") references "players"("id") on delete cascade on update no action,
  foreign key("alliance_id") references "alliances"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "notices"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "content" text not null,
  "created_at" datetime,
  "updated_at" datetime,
  "priority" integer,
  "alliance_id" integer not null default '1',
  foreign key("alliance_id") references "alliances"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "events"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "date" date not null,
  "created_at" datetime,
  "updated_at" datetime,
  "alliance_id" integer not null default '1',
  foreign key("alliance_id") references "alliances"("id") on delete cascade
);
CREATE INDEX "events_date_index" on "events"("date");
CREATE TABLE IF NOT EXISTS "event_categories"(
  "id" integer primary key autoincrement not null,
  "category" varchar not null,
  "alliance_id" integer not null default '1',
  foreign key("alliance_id") references "alliances"("id") on delete cascade
);
CREATE UNIQUE INDEX "event_categories_category_alliance_id_unique" on "event_categories"(
  "category",
  "alliance_id"
);
CREATE TABLE IF NOT EXISTS "pages"(
  "id" integer primary key autoincrement not null,
  "slug" varchar not null,
  "content" text not null,
  "created_at" datetime,
  "updated_at" datetime,
  "alliance_id" integer not null default '1',
  foreign key("alliance_id") references "alliances"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "player_participations"(
  "id" integer primary key autoincrement not null,
  "player_id" integer not null,
  "last_3_events" float,
  "one_month" float,
  "all_time" float,
  "combined_categories" varchar,
  "alliance_id" integer not null default '1',
  foreign key("player_id") references "players"("id") on delete cascade on update no action,
  foreign key("alliance_id") references "alliances"("id") on delete cascade
);
CREATE INDEX "player_participations_all_time_index" on "player_participations"(
  "all_time"
);
CREATE INDEX "player_participations_combined_categories_index" on "player_participations"(
  "combined_categories"
);
CREATE INDEX "player_participations_last_3_events_index" on "player_participations"(
  "last_3_events"
);
CREATE INDEX "player_participations_one_month_index" on "player_participations"(
  "one_month"
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2024_03_18_154027_create_notices_table',1);
INSERT INTO migrations VALUES(5,'2024_03_18_155937_notices_add_priority',1);
INSERT INTO migrations VALUES(6,'2024_04_03_183156_create_custom_pages_table',2);
INSERT INTO migrations VALUES(7,'2024_04_06_182644_rename_page_table',3);
INSERT INTO migrations VALUES(8,'2024_04_09_054547_create_permission_tables',4);
INSERT INTO migrations VALUES(9,'2024_04_11_111533_create_translated_notices_table',4);
INSERT INTO migrations VALUES(10,'2024_04_14_153727_set_translated_notice_content_null',5);
INSERT INTO migrations VALUES(11,'2024_04_14_181144_create_players_table',6);
INSERT INTO migrations VALUES(12,'2024_04_15_081741_player_add_more_info',7);
INSERT INTO migrations VALUES(13,'2024_04_15_084254_player_add_background',7);
INSERT INTO migrations VALUES(14,'2024_04_15_145251_create_comments_table',7);
INSERT INTO migrations VALUES(15,'2024_04_17_160134_create_translated_pages_table',8);
INSERT INTO migrations VALUES(16,'2024_04_26_174859_create_events_table',9);
INSERT INTO migrations VALUES(17,'2024_04_26_180447_create_attendees_table',9);
INSERT INTO migrations VALUES(18,'2024_04_26_205113_add_index_to_players',9);
INSERT INTO migrations VALUES(19,'2024_05_01_144939_event_add_index_date',10);
INSERT INTO migrations VALUES(20,'2024_05_01_160005_create_issues_table',11);
INSERT INTO migrations VALUES(21,'2024_05_02_134656_add_index_comments',12);
INSERT INTO migrations VALUES(22,'2024_05_02_204607_remove_comment_from_attendee',13);
INSERT INTO migrations VALUES(23,'2024_05_02_231438_add_field_translated_nickname_in_players',13);
INSERT INTO migrations VALUES(24,'2024_05_26_074241_remove_commitment_level',14);
INSERT INTO migrations VALUES(25,'2024_06_12_164516_create_player_participations_table',15);
INSERT INTO migrations VALUES(26,'2024_06_19_195602_create_agreements_table',16);
INSERT INTO migrations VALUES(27,'2024_06_19_202253_create_respondents_table',16);
INSERT INTO migrations VALUES(28,'2024_07_08_202210_create_player_maps_table',17);
INSERT INTO migrations VALUES(29,'2024_07_15_115908_create_telescope_entries_table',18);
INSERT INTO migrations VALUES(30,'2024_07_15_152308_create_internal_notes_table',19);
INSERT INTO migrations VALUES(31,'2024_07_21_065035_map_add_correct_flag',19);
INSERT INTO migrations VALUES(32,'2024_07_15_154130_create_event_categories_table',20);
INSERT INTO migrations VALUES(33,'2024_07_15_160345_connect_event_to_event_category',20);
INSERT INTO migrations VALUES(34,'2024_07_22_204650_player_participation_add_categories',20);
INSERT INTO migrations VALUES(35,'2024_08_22_162527_rename_comment_to_review',21);
INSERT INTO migrations VALUES(36,'2024_08_22_170148_create_alliances_table',21);
INSERT INTO migrations VALUES(37,'2024_08_22_180531_add_alliance_id_on_players',21);
INSERT INTO migrations VALUES(38,'2024_08_26_180852_add_alliance_id_on_agreements',21);
INSERT INTO migrations VALUES(39,'2024_08_26_181214_add_alliance_id_on_internal_notes',21);
INSERT INTO migrations VALUES(40,'2024_08_26_181806_add_alliance_id_on_player_maps',21);
INSERT INTO migrations VALUES(41,'2024_08_26_183607_add_alliance_id_on_notices',21);
INSERT INTO migrations VALUES(42,'2024_08_26_184907_add_alliance_id_on_events',21);
INSERT INTO migrations VALUES(43,'2024_08_26_185143_add_alliance_id_on_event_categories',21);
INSERT INTO migrations VALUES(44,'2024_08_26_185417_add_alliance_id_on_pages',21);
INSERT INTO migrations VALUES(45,'2024_08_26_204644_add_alliance_id_on_player_participations',21);
