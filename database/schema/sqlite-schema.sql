CREATE TABLE IF NOT EXISTS "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);
CREATE TABLE IF NOT EXISTS "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime);
CREATE UNIQUE INDEX "users_email_unique" on "users" ("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));
CREATE TABLE IF NOT EXISTS "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));
CREATE INDEX "sessions_user_id_index" on "sessions" ("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions" ("last_activity");
CREATE TABLE IF NOT EXISTS "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));
CREATE TABLE IF NOT EXISTS "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));
CREATE TABLE IF NOT EXISTS "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);
CREATE INDEX "jobs_queue_index" on "jobs" ("queue");
CREATE TABLE IF NOT EXISTS "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));
CREATE TABLE IF NOT EXISTS "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs" ("uuid");
CREATE TABLE IF NOT EXISTS "notices" ("id" integer primary key autoincrement not null, "title" varchar not null, "content" text not null, "created_at" datetime, "updated_at" datetime, "priority" integer);
CREATE TABLE IF NOT EXISTS "pages" ("id" integer primary key autoincrement not null, "slug" varchar not null, "content" text not null, "created_at" datetime, "updated_at" datetime);
CREATE TABLE IF NOT EXISTS "permissions" ("id" integer primary key autoincrement not null, "name" varchar not null, "guard_name" varchar not null, "created_at" datetime, "updated_at" datetime);
CREATE UNIQUE INDEX "permissions_name_guard_name_unique" on "permissions" ("name", "guard_name");
CREATE TABLE IF NOT EXISTS "roles" ("id" integer primary key autoincrement not null, "name" varchar not null, "guard_name" varchar not null, "created_at" datetime, "updated_at" datetime);
CREATE UNIQUE INDEX "roles_name_guard_name_unique" on "roles" ("name", "guard_name");
CREATE TABLE IF NOT EXISTS "model_has_permissions" ("permission_id" integer not null, "model_type" varchar not null, "model_id" integer not null, foreign key("permission_id") references "permissions"("id") on delete cascade, primary key ("permission_id", "model_id", "model_type"));
CREATE INDEX "model_has_permissions_model_id_model_type_index" on "model_has_permissions" ("model_id", "model_type");
CREATE TABLE IF NOT EXISTS "model_has_roles" ("role_id" integer not null, "model_type" varchar not null, "model_id" integer not null, foreign key("role_id") references "roles"("id") on delete cascade, primary key ("role_id", "model_id", "model_type"));
CREATE INDEX "model_has_roles_model_id_model_type_index" on "model_has_roles" ("model_id", "model_type");
CREATE TABLE IF NOT EXISTS "role_has_permissions" ("permission_id" integer not null, "role_id" integer not null, foreign key("permission_id") references "permissions"("id") on delete cascade, foreign key("role_id") references "roles"("id") on delete cascade, primary key ("permission_id", "role_id"));
CREATE TABLE IF NOT EXISTS "translated_notices" ("id" integer primary key autoincrement not null, "language" varchar not null, "content" text, "enable_auto_translation" tinyint(1) not null default '1', "notice_id" integer not null, "created_at" datetime, "updated_at" datetime);
CREATE TABLE IF NOT EXISTS "players" ("id" integer primary key autoincrement not null, "nickname" varchar not null, "rating" integer not null, "in_game_id" varchar not null, "rank" integer not null, "deleted_at" datetime, "created_at" datetime, "updated_at" datetime, "background" text);
CREATE UNIQUE INDEX "players_in_game_id_unique" on "players" ("in_game_id");
CREATE TABLE IF NOT EXISTS "translated_pages" ("id" integer primary key autoincrement not null, "content" text, "language" varchar not null, "enable_auto_translation" tinyint(1) not null, "page_id" integer not null, "created_at" datetime, "updated_at" datetime, foreign key("page_id") references "pages"("id") on delete cascade);
CREATE TABLE IF NOT EXISTS "comments"
(
    id               integer               not null
        primary key autoincrement,
    content          int                   not null,
    rating           int default 'neutral' not null,
    player_id        integer               not null
        references players
            on delete cascade,
    reviewer_user_id integer               not null,
    created_at       datetime,
    updated_at       datetime
);
CREATE TABLE IF NOT EXISTS "events" ("id" integer primary key autoincrement not null, "name" varchar not null, "date" date not null, "created_at" datetime, "updated_at" datetime);
CREATE TABLE IF NOT EXISTS "attendees" ("id" integer primary key autoincrement not null, "commitment_level" varchar not null, "is_commitment_fulfilled" varchar, "comment" text, "player_id" integer not null, "event_id" integer not null, foreign key("player_id") references "players"("id"), foreign key("event_id") references "events"("id") on delete cascade);
CREATE INDEX "players_nickname_index" on "players" ("nickname");
CREATE INDEX "events_date_index" on "events" ("date");
CREATE TABLE IF NOT EXISTS "issues" ("id" integer primary key autoincrement not null, "title" varchar not null, "description" text not null, "screenshots" text, "user_id" integer not null, "created_at" datetime, "updated_at" datetime, "solved_at" datetime, foreign key("user_id") references "users"("id"));
INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2024_03_18_154027_create_notices_table',1);
INSERT INTO migrations VALUES(5,'2024_03_18_155937_notices_add_priority',1);
INSERT INTO migrations VALUES(6,'2024_04_03_183156_create_custom_pages_table',1);
INSERT INTO migrations VALUES(7,'2024_04_06_182644_rename_page_table',1);
INSERT INTO migrations VALUES(8,'2024_04_09_054547_create_permission_tables',1);
INSERT INTO migrations VALUES(9,'2024_04_11_111533_create_translated_notices_table',1);
INSERT INTO migrations VALUES(10,'2024_04_14_153727_set_translated_notice_content_null',1);
INSERT INTO migrations VALUES(11,'2024_04_14_181144_create_players_table',2);
INSERT INTO migrations VALUES(12,'2024_04_15_081741_player_add_more_info',3);
INSERT INTO migrations VALUES(13,'2024_04_15_084254_player_add_background',4);
INSERT INTO migrations VALUES(15,'2024_04_15_145251_create_comments_table',5);
INSERT INTO migrations VALUES(17,'2024_04_17_160134_create_translated_pages_table',6);
INSERT INTO migrations VALUES(19,'2024_04_26_174859_create_events_table',7);
INSERT INTO migrations VALUES(20,'2024_04_26_180447_create_attendees_table',8);
INSERT INTO migrations VALUES(21,'2024_04_26_205113_add_index_to_players',9);
INSERT INTO migrations VALUES(22,'2024_05_01_144939_event_add_index_date',10);
INSERT INTO migrations VALUES(29,'2024_05_01_160005_create_issues_table',11);
