--
--    Copyright 2010-2016 the original author or authors.
--
--    Licensed under the Apache License, Version 2.0 (the "License");
--    you may not use this file except in compliance with the License.
--    You may obtain a copy of the License at
--
--       http://www.apache.org/licenses/LICENSE-2.0
--
--    Unless required by applicable law or agreed to in writing, software
--    distributed under the License is distributed on an "AS IS" BASIS,
--    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
--    See the License for the specific language governing permissions and
--    limitations under the License.
--

-- // google oauth
-- Migration SQL that makes the change goes here.

ALTER TABLE account ADD google_sub VARCHAR(500)
;

ALTER TABLE account MODIFY openid VARCHAR(500)
;
ALTER TABLE account MODIFY username VARCHAR(500)
;
ALTER TABLE account MODIFY password VARCHAR(500)
;
ALTER TABLE account MODIFY weeks_remaining VARCHAR(500)
;
ALTER TABLE account MODIFY last_backup VARCHAR(500)
;

-- //@UNDO
-- SQL to undo the change goes here.

ALTER TABLE account DROP COLUMN google_sub
;

-- don't set back to not null as this would require a default
ALTER TABLE account MODIFY openid VARCHAR(500)
;
ALTER TABLE account MODIFY username VARCHAR(500)
;
ALTER TABLE account MODIFY password VARCHAR(500)
;
ALTER TABLE account MODIFY weeks_remaining VARCHAR(500)
;
ALTER TABLE account MODIFY last_backup VARCHAR(500)
;
