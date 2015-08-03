/*INSERT INTO resource (name, display_name, description, is_public)
VALUES
('index', 'Index controller', 'Index controller desc', true),
('index:index', 'Index index action', 'Index index action desc', true),
('session', 'Session controller', 'Session controller desc', true),
('session:login', 'Login action', 'Login action desc', true),
('session:logout', 'Logout action', 'Logout action desc', true),
('user', 'User controller', 'User controller desc', false),
('user:index', 'User list', 'User list desc', false),
('user:create', 'User create', 'User create desc', false);*/

INSERT INTO "user" (name, email, crypt_hash, password_salt, active)
VALUES
('Administrator', 'admin@vgpg.icmc.usp.br', 'cab17e949435af0ae503188a64ce6a0d741d22a0', '9eb71ab7420eb452a22787ca4fab501b', true);

INSERT INTO "group" (name, is_admin, locked)
VALUES
('Admin', true, true),
('User', false, true);

INSERT INTO "user_group" (user_id, group_id)
VALUES
(1, 1);
/*
INSERT INTO "group_resource" (group_id, resource_id, type)
VALUES
(2, 6, true);*/
