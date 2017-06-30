<?php
	// utility-class for MySQL 5.7 written by Rainer Stötter, Altenburg, Germany)

/*
cMySql57_Utils:: (15 methods):
  AsDateTime()
  CheckServerConnection()
  ExistsDatabase()
  ExistsTable()
  ExistsTrigger()
  FileDateTime2DateTimeSQL()
  HasTables()
  IsClauseStart()
  IsIndexHintStart()
  IsJoinStart()
  IsJoinSyntax()
  IsKeyword()
  IsReservedWord()
  IsStartStatement()
  ServerVersion2int()
*/

namespace rstoetter\libsqlphp;

    /**
      * The keywords of MySQL as Array ( keyword, isReservedWord )
      *
      * @var string
      *
      *
      */

$_keywords_mysql_57 = array(

			array( 'ACCESSIBLE', true ),
			array( 'ACCOUNT', false ),
			array( 'ACTION', false ),
			array( 'ADD', true ),
			array( 'AFTER', false ),
			array( 'AGAINST', false ),
			array( 'AGGREGATE', false ),
			array( 'ALGORITHM', false ),
			array( 'ALL', true ),
			array( 'ALTER', true ),
			array( 'ALWAYS', false ),
			array( 'ANALYSE', false ),
			array( 'ANALYZE', true ),
			array( 'AND', true ),
			array( 'ANY', false ),
			array( 'AS', true ),
			array( 'ASC', true ),
			array( 'ASCII', false ),
			array( 'ASENSITIVE', true ),
			array( 'AT', false ),
			array( 'AUTOEXTEND_SIZE', false ),
			array( 'AUTO_INCREMENT', false ),
			array( 'AVG', false ),
			array( 'AVG_ROW_LENGTH', false ),
			array( 'BACKUP', false ),
			array( 'BEFORE', true ),
			array( 'BEGIN', false ),
			array( 'BETWEEN', true ),
			array( 'BIGINT', true ),
			array( 'BINARY', true ),
			array( 'BINLOG', false ),
			array( 'BIT', false ),
			array( 'BLOB', true ),
			array( 'BLOCK', false ),
			array( 'BOOL', false ),
			array( 'BOOLEAN', false ),
			array( 'BOTH', true ),
			array( 'BTREE', false ),
			array( 'BY', true ),
			array( 'BYTE', false ),
			array( 'CACHE', false ),
			array( 'CALL', true ),
			array( 'CASCADE', true ),
			array( 'CASCADED', false ),
			array( 'CASE', true ),
			array( 'CATALOG_NAME', false ),
			array( 'CHAIN', false ),
			array( 'CHANGE', true ),
			array( 'CHANGED', false ),
			array( 'CHANNEL', false ),
			array( 'CHAR', true ),
			array( 'CHARACTER', true ),
			array( 'CHARSET', false ),
			array( 'CHECK', true ),
			array( 'CHECKSUM', false ),
			array( 'CIPHER', false ),
			array( 'CLASS_ORIGIN', false ),
			array( 'CLIENT', false ),
			array( 'CLOSE', false ),
			array( 'COALESCE', false ),
			array( 'CODE', false ),
			array( 'COLLATE', true ),
			array( 'COLLATION', false ),
			array( 'COLUMN', true ),
			array( 'COLUMNS', false ),
			array( 'COLUMN_FORMAT', false ),
			array( 'COLUMN_NAME', false ),
			array( 'COMMENT', false ),
			array( 'COMMIT', false ),
			array( 'COMMITTED', false ),
			array( 'COMPACT', false ),
			array( 'COMPLETION', false ),
			array( 'COMPRESSED', false ),
			array( 'COMPRESSION', false ),
			array( 'CONCURRENT', false ),
			array( 'CONDITION', true ),
			array( 'CONNECTION', false ),
			array( 'CONSISTENT', false ),
			array( 'CONSTRAINT', true ),
			array( 'CONSTRAINT_CATALOG', false ),
			array( 'CONSTRAINT_NAME', false ),
			array( 'CONSTRAINT_SCHEMA', false ),
			array( 'CONTAINS', false ),
			array( 'CONTEXT', false ),
			array( 'CONTINUE', true ),
			array( 'CONVERT', true ),
			array( 'CPU', false ),
			array( 'CREATE', true ),
			array( 'CROSS', true ),
			array( 'CUBE', false ),
			array( 'CURRENT', false ),
			array( 'CURRENT_DATE', true ),
			array( 'CURRENT_TIME', true ),
			array( 'CURRENT_TIMESTAMP', true ),
			array( 'CURRENT_USER', true ),
			array( 'CURSOR', true ),
			array( 'CURSOR_NAME', false ),
			array( 'DATA', false ),
			array( 'DATABASE', true ),
			array( 'DATABASES', true ),
			array( 'DATAFILE', false ),
			array( 'DATE', false ),
			array( 'DATETIME', false ),
			array( 'DAY', false ),
			array( 'DAY_HOUR', true ),
			array( 'DAY_MICROSECOND', true ),
			array( 'DAY_MINUTE', true ),
			array( 'DAY_SECOND', true ),
			array( 'DEALLOCATE', false ),
			array( 'DEC', true ),
			array( 'DECIMAL', true ),
			array( 'DECLARE', true ),
			array( 'DEFAULT', true ),
			array( 'DEFAULT_AUTH', false ),
			array( 'DEFINER', false ),
			array( 'DELAYED', true ),
			array( 'DELAY_KEY_WRITE', false ),
			array( 'DELETE', true ),
			array( 'DESC', true ),
			array( 'DESCRIBE', true ),
			array( 'DES_KEY_FILE', false ),
			array( 'DETERMINISTIC', true ),
			array( 'DIAGNOSTICS', false ),
			array( 'DIRECTORY', false ),
			array( 'DISABLE', false ),
			array( 'DISCARD', false ),
			array( 'DISK', false ),
			array( 'DISTINCT', true ),
			array( 'DISTINCTROW', true ),
			array( 'DIV', true ),
			array( 'DO', false ),
			array( 'DOUBLE', true ),
			array( 'DROP', true ),
			array( 'DUAL', true ),
			array( 'DUMPFILE', false ),
			array( 'DUPLICATE', false ),
			array( 'DYNAMIC', false ),
			array( 'EACH', true ),
			array( 'ELSE', true ),
			array( 'ELSEIF', true ),
			array( 'ENABLE', false ),
			array( 'ENCLOSED', true ),
			array( 'ENCRYPTION', false ),
			array( 'END', false ),
			array( 'ENDS', false ),
			array( 'ENGINE', false ),
			array( 'ENGINES', false ),
			array( 'ENUM', false ),
			array( 'ERROR', false ),
			array( 'ERRORS', false ),
			array( 'ESCAPE', false ),
			array( 'ESCAPED', true ),
			array( 'EVENT', false ),
			array( 'EVENTS', false ),
			array( 'EVERY', false ),
			array( 'EXCHANGE', false ),
			array( 'EXECUTE', false ),
			array( 'EXISTS', true ),
			array( 'EXIT', true ),
			array( 'EXPANSION', false ),
			array( 'EXPIRE', false ),
			array( 'EXPLAIN', true ),
			array( 'EXPORT', false ),
			array( 'EXTENDED', false ),
			array( 'EXTENT_SIZE', false ),
			array( 'FALSE', true ),
			array( 'FAST', false ),
			array( 'FAULTS', false ),
			array( 'FETCH', true ),
			array( 'FIELDS', false ),
			array( 'FILE', false ),
			array( 'FILE_BLOCK_SIZE', false ),
			array( 'FILTER', false ),
			array( 'FIRST', false ),
			array( 'FIXED', false ),
			array( 'FLOAT', true ),
			array( 'FLOAT4', true ),
			array( 'FLOAT8', true ),
			array( 'FLUSH', false ),
			array( 'FOLLOWS', false ),
			array( 'FOR', true ),
			array( 'FORCE', true ),
			array( 'FOREIGN', true ),
			array( 'FORMAT', false ),
			array( 'FOUND', false ),
			array( 'FROM', true ),
			array( 'FULL', false ),
			array( 'FULLTEXT', true ),
			array( 'FUNCTION', false ),
			array( 'GENERAL', false ),
			array( 'GENERATED', true ),
			array( 'GEOMETRY', false ),
			array( 'GEOMETRYCOLLECTION', false ),
			array( 'GET', true ),
			array( 'GET_FORMAT', false ),
			array( 'GLOBAL', false ),
			array( 'GRANT', true ),
			array( 'GRANTS', false ),
			array( 'GROUP', true ),
			array( 'GROUP_REPLICATION', false ),
			array( 'HANDLER', false ),
			array( 'HASH', false ),
			array( 'HAVING', true ),
			array( 'HELP', false ),
			array( 'HIGH_PRIORITY', true ),
			array( 'HOST', false ),
			array( 'HOSTS', false ),
			array( 'HOUR', false ),
			array( 'HOUR_MICROSECOND', true ),
			array( 'HOUR_MINUTE', true ),
			array( 'HOUR_SECOND', true ),
			array( 'IDENTIFIED', false ),
			array( 'IF', true ),
			array( 'IGNORE', true ),
			array( 'IGNORE_SERVER_IDS', false ),
			array( 'IMPORT', false ),
			array( 'IN', true ),
			array( 'INDEX', true ),
			array( 'INDEXES', false ),
			array( 'INFILE', true ),
			array( 'INITIAL_SIZE', false ),
			array( 'INNER', true ),
			array( 'INOUT', true ),
			array( 'INSENSITIVE', true ),
			array( 'INSERT', true ),
			array( 'INSERT_METHOD', false ),
			array( 'INSTALL', false ),
			array( 'INSTANCE', false ),
			array( 'INT', true ),
			array( 'INT1', true ),
			array( 'INT2', true ),
			array( 'INT3', true ),
			array( 'INT4', true ),
			array( 'INT8', true ),
			array( 'INTEGER', true ),
			array( 'INTERVAL', true ),
			array( 'INTO', true ),
			array( 'INVOKER', false ),
			array( 'IO', false ),
			array( 'IO_AFTER_GTIDS', true ),
			array( 'IO_BEFORE_GTIDS', true ),
			array( 'IO_THREAD', false ),
			array( 'IPC', false ),
			array( 'IS', true ),
			array( 'ISOLATION', false ),
			array( 'ISSUER', false ),
			array( 'ITERATE', true ),
			array( 'JOIN', true ),
			array( 'JSON', false ),
			array( 'KEY', true ),
			array( 'KEYS', true ),
			array( 'KEY_BLOCK_SIZE', false ),
			array( 'KILL', true ),
			array( 'LANGUAGE', false ),
			array( 'LAST', false ),
			array( 'LEADING', true ),
			array( 'LEAVE', true ),
			array( 'LEAVES', false ),
			array( 'LEFT', true ),
			array( 'LESS', false ),
			array( 'LEVEL', false ),
			array( 'LIKE', true ),
			array( 'LIMIT', true ),
			array( 'LINEAR', true ),
			array( 'LINES', true ),
			array( 'LINESTRING', false ),
			array( 'LIST', false ),
			array( 'LOAD', true ),
			array( 'LOCAL', false ),
			array( 'LOCALTIME', true ),
			array( 'LOCALTIMESTAMP', true ),
			array( 'LOCK', true ),
			array( 'LOCKS', false ),
			array( 'LOGFILE', false ),
			array( 'LOGS', false ),
			array( 'LONG', true ),
			array( 'LONGBLOB', true ),
			array( 'LONGTEXT', true ),
			array( 'LOOP', true ),
			array( 'LOW_PRIORITY', true ),
			array( 'MASTER', false ),
			array( 'MASTER_AUTO_POSITION', false ),
			array( 'MASTER_BIND', true ),
			array( 'MASTER_CONNECT_RETRY', false ),
			array( 'MASTER_DELAY', false ),
			array( 'MASTER_HEARTBEAT_PERIOD', false ),
			array( 'MASTER_HOST', false ),
			array( 'MASTER_LOG_FILE', false ),
			array( 'MASTER_LOG_POS', false ),
			array( 'MASTER_PASSWORD', false ),
			array( 'MASTER_PORT', false ),
			array( 'MASTER_RETRY_COUNT', false ),
			array( 'MASTER_SERVER_ID', false ),
			array( 'MASTER_SSL', false ),
			array( 'MASTER_SSL_CA', false ),
			array( 'MASTER_SSL_CAPATH', false ),
			array( 'MASTER_SSL_CERT', false ),
			array( 'MASTER_SSL_CIPHER', false ),
			array( 'MASTER_SSL_CRL', false ),
			array( 'MASTER_SSL_CRLPATH', false ),
			array( 'MASTER_SSL_KEY', false ),
			array( 'MASTER_SSL_VERIFY_SERVER_CERT', true ),
			array( 'MASTER_TLS_VERSION', false ),
			array( 'MASTER_USER', false ),
			array( 'MATCH', true ),
			array( 'MAXVALUE', true ),
			array( 'MAX_CONNECTIONS_PER_HOUR', false ),
			array( 'MAX_QUERIES_PER_HOUR', false ),
			array( 'MAX_ROWS', false ),
			array( 'MAX_SIZE', false ),
			array( 'MAX_STATEMENT_TIME', false ),
			array( 'MAX_UPDATES_PER_HOUR', false ),
			array( 'MAX_USER_CONNECTIONS', false ),
			array( 'MEDIUM', false ),
			array( 'MEDIUMBLOB', true ),
			array( 'MEDIUMINT', true ),
			array( 'MEDIUMTEXT', true ),
			array( 'MEMORY', false ),
			array( 'MERGE', false ),
			array( 'MESSAGE_TEXT', false ),
			array( 'MICROSECOND', false ),
			array( 'MIDDLEINT', true ),
			array( 'MIGRATE', false ),
			array( 'MINUTE', false ),
			array( 'MINUTE_MICROSECOND', true ),
			array( 'MINUTE_SECOND', true ),
			array( 'MIN_ROWS', false ),
			array( 'MOD', true ),
			array( 'MODE', false ),
			array( 'MODIFIES', true ),
			array( 'MODIFY', false ),
			array( 'MONTH', false ),
			array( 'MULTILINESTRING', false ),
			array( 'MULTIPOINT', false ),
			array( 'MULTIPOLYGON', false ),
			array( 'MUTEX', false ),
			array( 'MYSQL_ERRNO', false ),
			array( 'NAME', false ),
			array( 'NAMES', false ),
			array( 'NATIONAL', false ),
			array( 'NATURAL', true ),
			array( 'NCHAR', false ),
			array( 'NDB', false ),
			array( 'NDBCLUSTER', false ),
			array( 'NEVER', false ),
			array( 'NEW', false ),
			array( 'NEXT', false ),
			array( 'NO', false ),
			array( 'NODEGROUP', false ),
			array( 'NONBLOCKING', false ),
			array( 'NONE', false ),
			array( 'NOT', true ),
			array( 'NO_WAIT', false ),
			array( 'NO_WRITE_TO_BINLOG', true ),
			array( 'NULL', true ),
			array( 'NUMBER', false ),
			array( 'NUMERIC', true ),
			array( 'NVARCHAR', false ),
			array( 'OFFSET', false ),
			array( 'OLD_PASSWORD', false ),
			array( 'ON', true ),
			array( 'ONE', false ),
			array( 'ONLY', false ),
			array( 'OPEN', false ),
			array( 'OPTIMIZE', true ),
			array( 'OPTIMIZER_COSTS', true ),
			array( 'OPTION', true ),
			array( 'OPTIONALLY', true ),
			array( 'OPTIONS', false ),
			array( 'OR', true ),
			array( 'ORDER', true ),
			array( 'OUT', true ),
			array( 'OUTER', true ),
			array( 'OUTFILE', true ),
			array( 'OWNER', false ),
			array( 'PACK_KEYS', false ),
			array( 'PAGE', false ),
			array( 'PARSER', false ),
			array( 'PARSE_GCOL_EXPR', false ),
			array( 'PARTIAL', false ),
			array( 'PARTITION', true ),
			array( 'PARTITIONING', false ),
			array( 'PARTITIONS', false ),
			array( 'PASSWORD', false ),
			array( 'PHASE', false ),
			array( 'PLUGIN', false ),
			array( 'PLUGINS', false ),
			array( 'PLUGIN_DIR', false ),
			array( 'POINT', false ),
			array( 'POLYGON', false ),
			array( 'PORT', false ),
			array( 'PRECEDES', false ),
			array( 'PRECISION', true ),
			array( 'PREPARE', false ),
			array( 'PRESERVE', false ),
			array( 'PREV', false ),
			array( 'PRIMARY', true ),
			array( 'PRIVILEGES', false ),
			array( 'PROCEDURE', true ),
			array( 'PROCESSLIST', false ),
			array( 'PROFILE', false ),
			array( 'PROFILES', false ),
			array( 'PROXY', false ),
			array( 'PURGE', true ),
			array( 'QUARTER', false ),
			array( 'QUERY', false ),
			array( 'QUICK', false ),
			array( 'RANGE', true ),
			array( 'READ', true ),
			array( 'READS', true ),
			array( 'READ_ONLY', false ),
			array( 'READ_WRITE', true ),
			array( 'REAL', true ),
			array( 'REBUILD', false ),
			array( 'RECOVER', false ),
			array( 'REDOFILE', false ),
			array( 'REDO_BUFFER_SIZE', false ),
			array( 'REDUNDANT', false ),
			array( 'REFERENCES', true ),
			array( 'REGEXP', true ),
			array( 'RELAY', false ),
			array( 'RELAYLOG', false ),
			array( 'RELAY_LOG_FILE', false ),
			array( 'RELAY_LOG_POS', false ),
			array( 'RELAY_THREAD', false ),
			array( 'RELEASE', true ),
			array( 'RELOAD', false ),
			array( 'REMOVE', false ),
			array( 'RENAME', true ),
			array( 'REORGANIZE', false ),
			array( 'REPAIR', false ),
			array( 'REPEAT', true ),
			array( 'REPEATABLE', false ),
			array( 'REPLACE', true ),
			array( 'REPLICATE_DO_DB', false ),
			array( 'REPLICATE_DO_TABLE', false ),
			array( 'REPLICATE_IGNORE_DB', false ),
			array( 'REPLICATE_IGNORE_TABLE', false ),
			array( 'REPLICATE_REWRITE_DB', false ),
			array( 'REPLICATE_WILD_DO_TABLE', false ),
			array( 'REPLICATE_WILD_IGNORE_TABLE', false ),
			array( 'REPLICATION', false ),
			array( 'REQUIRE', true ),
			array( 'RESET', false ),
			array( 'RESIGNAL', true ),
			array( 'RESTORE', false ),
			array( 'RESTRICT', true ),
			array( 'RESUME', false ),
			array( 'RETURN', true ),
			array( 'RETURNED_SQLSTATE', false ),
			array( 'RETURNS', false ),
			array( 'REVERSE', false ),
			array( 'REVOKE', true ),
			array( 'RIGHT', true ),
			array( 'RLIKE', true ),
			array( 'ROLLBACK', false ),
			array( 'ROLLUP', false ),
			array( 'ROTATE', false ),
			array( 'ROUTINE', false ),
			array( 'ROW', false ),
			array( 'ROWS', false ),
			array( 'ROW_COUNT', false ),
			array( 'ROW_FORMAT', false ),
			array( 'RTREE', false ),
			array( 'SAVEPOINT', false ),
			array( 'SCHEDULE', false ),
			array( 'SCHEMA', true ),
			array( 'SCHEMAS', true ),
			array( 'SCHEMA_NAME', false ),
			array( 'SECOND', false ),
			array( 'SECOND_MICROSECOND', true ),
			array( 'SECURITY', false ),
			array( 'SELECT', true ),
			array( 'SENSITIVE', true ),
			array( 'SEPARATOR', true ),
			array( 'SERIAL', false ),
			array( 'SERIALIZABLE', false ),
			array( 'SERVER', false ),
			array( 'SESSION', false ),
			array( 'SET', true ),
			array( 'SHARE', false ),
			array( 'SHOW', true ),
			array( 'SHUTDOWN', false ),
			array( 'SIGNAL', true ),
			array( 'SIGNED', false ),
			array( 'SIMPLE', false ),
			array( 'SLAVE', false ),
			array( 'SLOW', false ),
			array( 'SMALLINT', true ),
			array( 'SNAPSHOT', false ),
			array( 'SOCKET', false ),
			array( 'SOME', false ),
			array( 'SONAME', false ),
			array( 'SOUNDS', false ),
			array( 'SOURCE', false ),
			array( 'SPATIAL', true ),
			array( 'SPECIFIC', true ),
			array( 'SQL', true ),
			array( 'SQLEXCEPTION', true ),
			array( 'SQLSTATE', true ),
			array( 'SQLWARNING', true ),
			array( 'SQL_AFTER_GTIDS', false ),
			array( 'SQL_AFTER_MTS_GAPS', false ),
			array( 'SQL_BEFORE_GTIDS', false ),
			array( 'SQL_BIG_RESULT', true ),
			array( 'SQL_BUFFER_RESULT', false ),
			array( 'SQL_CACHE', false ),
			array( 'SQL_CALC_FOUND_ROWS', true ),
			array( 'SQL_NO_CACHE', false ),
			array( 'SQL_SMALL_RESULT', true ),
			array( 'SQL_THREAD', false ),
			array( 'SQL_TSI_DAY', false ),
			array( 'SQL_TSI_HOUR', false ),
			array( 'SQL_TSI_MINUTE', false ),
			array( 'SQL_TSI_MONTH', false ),
			array( 'SQL_TSI_QUARTER', false ),
			array( 'SQL_TSI_SECOND', false ),
			array( 'SQL_TSI_WEEK', false ),
			array( 'SQL_TSI_YEAR', false ),
			array( 'SSL', true ),
			array( 'STACKED', false ),
			array( 'START', false ),
			array( 'STARTING', true ),
			array( 'STARTS', false ),
			array( 'STATS_AUTO_RECALC', false ),
			array( 'STATS_PERSISTENT', false ),
			array( 'STATS_SAMPLE_PAGES', false ),
			array( 'STATUS', false ),
			array( 'STOP', false ),
			array( 'STORAGE', false ),
			array( 'STORED', true ),
			array( 'STRAIGHT_JOIN', true ),
			array( 'STRING', false ),
			array( 'SUBCLASS_ORIGIN', false ),
			array( 'SUBJECT', false ),
			array( 'SUBPARTITION', false ),
			array( 'SUBPARTITIONS', false ),
			array( 'SUPER', false ),
			array( 'SUSPEND', false ),
			array( 'SWAPS', false ),
			array( 'SWITCHES', false ),
			array( 'TABLE', true ),
			array( 'TABLES', false ),
			array( 'TABLESPACE', false ),
			array( 'TABLE_CHECKSUM', false ),
			array( 'TABLE_NAME', false ),
			array( 'TEMPORARY', false ),
			array( 'TEMPTABLE', false ),
			array( 'TERMINATED', true ),
			array( 'TEXT', false ),
			array( 'THAN', false ),
			array( 'THEN', true ),
			array( 'TIME', false ),
			array( 'TIMESTAMP', false ),
			array( 'TIMESTAMPADD', false ),
			array( 'TIMESTAMPDIFF', false ),
			array( 'TINYBLOB', true ),
			array( 'TINYINT', true ),
			array( 'TINYTEXT', true ),
			array( 'TO', true ),
			array( 'TRAILING', true ),
			array( 'TRANSACTION', false ),
			array( 'TRIGGER', true ),
			array( 'TRIGGERS', false ),
			array( 'TRUE', true ),
			array( 'TRUNCATE', false ),
			array( 'TYPE', false ),
			array( 'TYPES', false ),
			array( 'UNCOMMITTED', false ),
			array( 'UNDEFINED', false ),
			array( 'UNDO', true ),
			array( 'UNDOFILE', false ),
			array( 'UNDO_BUFFER_SIZE', false ),
			array( 'UNICODE', false ),
			array( 'UNINSTALL', false ),
			array( 'UNION', true ),
			array( 'UNIQUE', true ),
			array( 'UNKNOWN', false ),
			array( 'UNLOCK', true ),
			array( 'UNSIGNED', true ),
			array( 'UNTIL', false ),
			array( 'UPDATE', true ),
			array( 'UPGRADE', false ),
			array( 'USAGE', true ),
			array( 'USE', true ),
			array( 'USER', false ),
			array( 'USER_RESOURCES', false ),
			array( 'USE_FRM', false ),
			array( 'USING', true ),
			array( 'UTC_DATE', true ),
			array( 'UTC_TIME', true ),
			array( 'UTC_TIMESTAMP', true ),
			array( 'VALIDATION', false ),
			array( 'VALUE', false ),
			array( 'VALUES', true ),
			array( 'VARBINARY', true ),
			array( 'VARCHAR', true ),
			array( 'VARCHARACTER', true ),
			array( 'VARIABLES', false ),
			array( 'VARYING', true ),
			array( 'VIEW', false ),
			array( 'VIRTUAL', true ),
			array( 'WAIT', false ),
			array( 'WARNINGS', false ),
			array( 'WEEK', false ),
			array( 'WEIGHT_STRING', false ),
			array( 'WHEN', true ),
			array( 'WHERE', true ),
			array( 'WHILE', true ),
			array( 'WITH', true ),
			array( 'WITHOUT', false ),
			array( 'WORK', false ),
			array( 'WRAPPER', false ),
			array( 'WRITE', true ),
			array( 'X509', false ),
			array( 'XA', false ),
			array( 'XID', false ),
			array( 'XML', false ),
			array( 'XOR', true ),
			array( 'YEAR', false ),
			array( 'YEAR_MONTH', true ),
			array( 'ZEROFILL', true )
		);

/*

examples:

echo "\n" . ( cMysql57_Utils::IsKeyword( 'select' ) ? 'select ist ein keyword' : 'select ist kein keyword' );
echo "\n" . ( cMysql57_Utils::IsReservedWord( 'insert' ) ? 'insert ist ein reserved word' : 'select ist kein reserved word' );
echo "\n" . ( cMysql57_Utils::IsKeyword( 'nonsense' ) ? 'nonsense ist ein keyword' : 'nonsense ist kein keyword' );
echo "\n" . ( cMysql57_Utils::IsReservedWord( 'nonsense' ) ? 'nonsense ist ein reserved word' : 'nonsense ist kein reserved word' );

*/



/**
  *
  * The class cMySql57_Utils provides utilities for mySQL v5,7
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */



class cMySql57_Utils {

    /**
      * const for the database: the connection is okay
      *
      * @var int
      *
      *
      */

const  ERROR_NONE= 1 ;		// alles okay

    /**
      * const for the database: no server available
      *
      * @var int
      *
      *
      */


const  ERROR_2002= 2 ;		// kein Server verfügbar

    /**
      * const for the database: the login failed
      *
      * @var int
      *
      *
      */


const  ERROR_1045= 4 ;		// Login-Daten inkorrekt

    /**
      * const for the database: another error occured
      *
      * @var int
      *
      *
      */


const  ERROR_ELSE= 8 ;		// anderer Fehler

    /**
      * bit mask entry the method CheckServerConnection( ) returns: Server is available
      *
      * @var int
      *
      *
      */


 const  MASK_SERVER_AVAILABLE= 1 ;		// Server steht zur Verfügung

    /**
      * bit mask entry the method CheckServerConnection( ) returns: Server connect was successful
      *
      * @var int
      *
      *
      */


 const  MASK_SERVER_CONNECTED= 2 ;		// Connect zum Server war erfolgreich

     /**
      * bit mask entry the method CheckServerConnection( ) returns: Login was successful
      *
      * @var int
      *
      *
      */


 const  MASK_SERVER_LOGIN_SUCCESSFUL= 4 ;	// Login war erfolgreich

    /**
      * bit mask entry the method CheckServerConnection( ) returns: if not set then there was a failure
      *
      * @var int
      *
      *
      */


 const  MASK_SERVER_OKAY= 8 ;			// falls nicht gesetzt= dann allgemeiner Fehler

     /**
      * bit mask entry the method CheckServerConnection( ) returns: Server is available and can be pinged
      *
      * @var int
      *
      *
      */


 const  MASK_SERVER_ALIVE = 16 ;		// Datenbank-Server reagiert auf Ping


     /**
      *
      * The method IsKeyword returns true, if $tst is a keyword
      *
      * Example:
      *
      *
      * @param string $tst the keyword to test
      * @return bool true, if $tst is a keyword
      *
      */

    static public function IsKeyword( $tst ) {

	global $_keywords_mysql_57;

	$tst = strtoupper( trim( $tst ) );

	for ( $i = 0; $i < count( $_keywords_mysql_57  ); $i++ ) {

	    if ( $_keywords_mysql_57[ $i ][ 0 ] == $tst ) return true;

	}

	return false;

    }	// function IsKeyword( )

     /**
      *
      * The method IsReservedWord returns true, if $tst is a reserved word
      *
      * Example:
      *
      *
      * @param string $tst the keyword to test
      * @return bool true, if $tst is a reserved word
      *
      */


    static public function IsReservedWord( $tst ) {

	global $_keywords_mysql_57;

	$tst = strtoupper( trim( $tst ) );

	for ( $i = 0; $i < count( $_keywords_mysql_57  ); $i++ ) {

	    if ( ( $_keywords_mysql_57[ $i ][ 0 ] == $tst ) && ( $_keywords_mysql_57[ $i ][ 1 ] ) ) return true;

	}

	return false;

    }	// function IsReservedWord( )

     /**
      *
      * The method IsStartStatement returns true, if $id is a start statement ( if it is a statement modifier )
      *
      * Example:
      *
      *
      * @param string $id the keyword to test
      * @return bool true, if $id is a start statement
      *
      */


	static public function IsStartStatement( $id ) {

	    $id = strtoupper( $id );

	    if ( ( $id == 'ALL') ||
		( $id == 'DISTINCT' ) ||
		( $id == 'DISTINCTROW' ) ||
		( $id == 'HIGH_PRIORITY' ) ||
		( $id == 'SQL_SMALL_RESULT' ) ||
		( $id == 'SQL_BIG_RESULT' ) ||
		( $id == 'SQL_BUFFER_RESULT' ) ||
		( $id == 'SQL_CACHE' ) ||
		( $id == 'SQL_NO_CACHE' ) ||
		( $id == 'SQL_CALC_FOUND_ROWS' ) ||
		( $id == 'STRAIGHT_JOIN' ) ||
		( $id == 'MAX_STATEMENT_TIME' )
		) {

		return true;

	    }

	    // [MAX_STATEMENT_TIME = N] hat zwei weitere Token!


	}	// function IsStartStatement


     /**
      *
      * The method IsJoinStart returns true, if $clause starts a join
      *
      * Example:
      *
      *
      * @param string $clause the keyword to test
      * @return bool true, if $clause starts a join
      *
      */

      static public function IsJoinStart( $clause ) {

	$clause = strtoupper( trim( $clause ) );

	return  ( $clause == 'LEFT' ) ||
		( $clause == 'JOIN' ) ||
		( $clause == 'INNER' ) ||
		( $clause == 'CROSS' ) ||
		( $clause == 'STRAIGHT_JOIN' ) ||
		( $clause == 'NATURAL' ) ||
		( $clause == 'RIGHT' )
		;

      }	// function IsJoinStart( )


     /**
      *
      * The method IsJoinSyntax returns true, if $keyword belongs to a join
      *
      * Example:
      *
      *
      * @param string $keyword the keyword to test
      * @return bool true, if $keyword belongs to a join
      *
      */


      static public function IsJoinSyntax( $keyword ) {

	  $keyword = strtoupper( trim( $keyword ) );

	  return self::IsJoinStart( $keyword ) ||
		( $keyword == 'USE' ) ||
		( $keyword == 'USING' ) ||
		( $keyword == 'ON' ) ||
		( $keyword == 'IGNORE' ) ||
		( $keyword == 'FORCE' )
		;

      }	// function IsJoinSyntax( )

     /**
      *
      * The method IsIndexHintStart returns true, if $clause belongs to an index hint
      *
      * Example:
      *
      *
      * @param string $clause the keyword to test
      * @return bool true, if $clause belongs to an index hint
      *
      */


      static public function IsIndexHintStart( $clause ) {

	$clause = strtoupper( trim( $clause ) );

	return  ( $clause == 'USE' ) ||
		( $clause == 'IGNORE' ) ||
		( $clause == 'FORCE' )
		;

      }	// function IsIndexHintStart( )

     /**
      *
      * The method IsClauseStart returns true, if $clause starts a clause
      *
      * Example:
      *
      *
      * @return bool true, if $clause starts a clause
      *
      */


      static public function IsClauseStart( $clause ) {

	$clause = strtoupper( trim( $clause ) );

	return  ( $clause == 'WHERE' ) ||
		( $clause == 'ORDER' ) ||
		( $clause == 'GROUP' ) ||
		( $clause == 'HAVING' ) ||
		( $clause == 'LIMIT' )
		;

      }	// function IsClauseStart( )

     /**
      *
      * The method ExistsTrigger returns true, if there is a trigger withe the name $triggername in the database
      *
      * Example:
      *
      *
      * @param mysqli the database connection
      * @param string name the name of the trigger
      * @return bool true, if there is a trigger withe the name $triggername in the database
      *
      */


    static public function ExistsTrigger( $mysqli, $triggername ) {

      $found = false;


	$query = "
    SHOW TRIGGERS
    ";

	$result = $mysqli->query( $query );
	if ($result) {

	    for ( $i = 0; $i < $result->num_rows; $i++ ) {

		$row = $result->fetch_object(  );
		if ( $row-> Trigger == $triggername ) {
		    $found = true;
		    break;
		}
	    }

	    $result->close;
	}
	return $found;

    }   // function ExistsTrigger()

     /**
      *
      * The method ExistsDatabase returns true, if there is a database with the name $dbname
      *
      * Example:
      *
      *
      * @param mysqli the database connection
      * @param string $dbame name the name of the database
      * @return bool true, if there is a database with the name $dbname
      *
      */


    static public function ExistsDatabase( $mysqli, $dbname ) {

	$ret = false;

	$query = "SHOW DATABASES LIKE '" .$dbname . "'";

	if ( $mysqli !== false ) {
	    $result = @$mysqli->query( $query );

	    if ( $result !== false ) {

		$ret = (  $result->num_rows != 0 );

		$result->close( );
	    }
	}

	return $ret;


    }   // function ExistsDatabase( )

     /**
      *
      * The method ExistsTable returns true, if there is a table with the name $tablename in the actual database
      *
      * Example:
      *
      *
      * @param mysqli the database connection
      * @param string $tablename the name of the table
      * @return bool true, if there is a table with the name $tablename in the actual database
      *
      */



    static function ExistsTable( $mysqli, $tablename ) {

	assert( strlen( trim( $tablename ) ) );

	$query = "SHOW TABLES LIKE '$tablename'";

	$result = $mysqli->query( $query );
	if ( $result !== false ) {

	    $found = ( $result->num_rows == 1 );
	    $result->close();

	}

	return $found;

    }   // function ExistsTable()

     /**
      *
      * The method HasTables returns true, if there is are tables in the actual database
      *
      * Example:
      *
      *
      * @param mysqli the database connection
      * @return bool true, if there is are tables in the actual database
      *
      */

    static public function HasTables( $mysqli ) {

	$ret = true;

	$query = 'SHOW TABLES';

	$result = $mysqli->query( $query );

	if ( $result !== false ) {

	    $ret = (  $result->num_rows != 0 );

	    $result->close( );

	}

	return $ret;

    }   // function HasTables( )

     /**
      *
      * The method FileDateTime2DateTimeSQL returns the sql notation of the datetime $dt
      *
      * Example:
      *
      *
      * @param int $dt
      * @return string the sql notation of the datetime $dt
      *
      */

    static public function FileDateTime2DateTimeSQL( $dt ) {

    // 2010-03-09 23:47:13

    return date ('Y-m-d H:i:s', $dt );

    }   // function FileDateTime2DateTimeSQL( )

     /**
      *
      * The method AsDateTime converts the sql notation $str to a datetime
      *
      * Example:
      *
      *
      * @param string $str the sql notation
      * @return int the datetime
      *
      */


    static public function AsDateTime( $str ) {

	list($year, $month, $day, $hour, $min, $sec) = sscanf( $str, '%d-%d-%d %d:%d:%d' );

	$tm = mktime( $hour,$min, $sec, $month, $day, $year) ;

	return $tm;

    }   // function asDateTime( )


     /**
      *
      * The method CheckServerConnection tests the server connection
      *
      * Example:
      *
      *
      * @param string $host the name of the host
      * @param string $account the name of the user
      * @param string $password the password of the user
      * @return int a bit mask
      * @see MASK_SERVER_ALIVE
      * @see MASK_SERVER_AVAILABLE
      * @see MASK_SERVER_CONNECTED
      * @see MASK_SERVER_LOGIN_SUCCESSFUL
      * @see MASK_SERVER_OKAY
      *
      */

    static public function CheckServerConnection( $host, $account, $password ) {

        $this->m_server_connect = false;
        $this->m_server_ping = false;
        $this->m_server_version_ok = false;
        $ret = ERROR_NONE;
        $mask = 0;

        $mysqli = new mysqli( $host_, $account, $password );

        /* check connection */
        if ( mysqli_connect_errno( ) == 2002 ) {        // kein Server verfügbar
            $ret = ERROR_2002;
        } else {
	    $mask |= self::MASK_SERVER_AVAILABLE;
	    $mask |= self::MASK_SERVER_CONNECTED;
        }


        if ( mysqli_connect_errno( ) == 1045 ) {  // akzeptiert Benutzernamen/Passwort nicht
	    $ret = ERROR_1045;
        } else {
	    $mask |= self::MASK_SERVER_LOGIN_SUCCESSFUL;
        }

        if ( mysqli_connect_errno( ) ) {
	    $ret = ERROR_ELSE;        	// allgemeiner Fehler
        } else {
	    $mask |= self::MASK_SERVER_OKAY;
        }

        if ( ! mysqli_connect_errno( ) ) {

            /* check if server is alive */
            if ( $mysqli->ping( ) ) {
                $mask |= self::MASK_SERVER_ALIVE;

                $mysqli->close( );

            }
        }

        return  $mask;

    }   // function CheckServerConnection( )

     /**
      *
      * The method ServerVersion2int( ) returns the int notation of the version string $version
      *
      * Example:
      *
      *
      * @param string $version the string notation of the version (1.002)
      * @return int the int notation : main_version * 10000 + minor_version * 100 + sub_version (i.e. version 4.1.0 is 40100).
      *
      */


    static public function ServerVersion2int( $version ) {

        // The form of this version number is main_version * 10000 + minor_version * 100 + sub_version (i.e. version 4.1.0 is 40100).

        $ret = -1;

        $main = strtok( $version, '.' );
        $minor = strtok( '.' );

        $subversion = substr( $version, strpos( $version, '.' ) +1 );
        if ( strpos( $subversion, '.'  ) == false ) $subversion = 0; else $subversion = substr( $subversion, strpos( $subversion, '.' ) +1 );

        $ret = $main * 10000 + $minor * 100 + $subversion;

        // echo "<br>main = $main minor = $minor subversion = $subversion int = $ret";

        return $ret;

    }   // function ServerVersion2int( )


}	// class cMySql57_Utils



?>