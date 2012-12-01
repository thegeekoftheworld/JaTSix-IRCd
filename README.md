Modfwango
=========

Modfwango is an IRCd written in PHP.  The two objectives that v0.9 of this project aims to meet are:

* To be (almost) RFC 1459 compliant.  See below for more details.
* To provide a standalone IRC daemon that is unlinkable.

The objective that v1.0 of this project aims to meet is:

* To provide a linking protocol compatible with other Modfwango daemons and Charybdis.

RFC 1459 Compliancy
===================

As mentioned in the previous section, RFC 1459 partial compliancy will have to be met.  This means that a few commands were omitted, and some have been changed.  The following commands will have to be implemented:

###ADMIN
Syntax:  ```ADMIN```

> Instructs the server to return information about the administrator of the current server.

###AWAY
Syntax:  ```AWAY [<message>]```

> Provides the server with a message to automatically send in reply to a PRIVMSG directed at the user, but not to a channel they are on. If <message> is omitted, the away status is removed.

###DIE
Syntax:  ```DIE```

> Instructs the server to shut down.

###ERROR
Syntax:  ```ERROR <error message>```

> This command is used before terminating client connections.

###INFO
Syntax:  ```INFO```

> Returns information about the current server. Information returned includes the server's version, when it was compiled, the patch level, when it was started, and any other information which may be considered to be relevant.

###INVITE
Syntax:  ```INVITE <nickname> <channel>```

> Invites <nickname> to the channel <channel>. <channel> does not have to exist, but if it does, only members of the channel are allowed to invite other clients. If the channel mode i is set, only channel operators may invite other clients.

###ISON
Syntax:  ```ISON <nicknames>```

> Queries the server to see if the clients in the space-separated list <nicknames> are currently on the network. The server returns only the nicknames that are on the network in a space-separated list. If none of the clients are on the network the server returns an empty list.

###JOIN
Syntax:  ```JOIN <channels> [<keys>]```

> Makes the client join the channels in the comma-separated list <channels>, specifying the passwords, if needed, in the comma-separated list <keys>. If the channel(s) do not exist then they will be created.

###KICK
Syntax:  ```KICK <channel> <client> [<message>]```

> Forcibly removes <client> from <channel>. This command may only be issued by channel operators.

###KILL
Syntax:  ```KILL <client> <comment>```

> Forcibly removes <client> from the network. This command may only be issued by IRC operators.

###LIST
Syntax:  ```LIST [<channels>]```

> Lists all channels on the server. If the comma-separated list <channels> is given, it will return the channel topics.

###LUSERS
Syntax:  ```LUSERS [<mask>]```

> Returns statistics about the size of the network. If called with no arguments, the statistics will reflect the entire network. If <mask> is given, it will return only statistics reflecting the masked subset of the network.

###MODE
Syntax:  ```MODE <nickname> <flags> [<args>]```

Syntax:  ```MODE <channel> <flags> [<args>]```

> The MODE command is dual-purpose. It can be used to set both user and channel modes.

###MOTD
Syntax:  ```MOTD```

> Returns the message of the day on the current server.

###NAMES
Syntax:  ```NAMES [<channels>]```

> Returns a list of who is on the comma-separated list of <channels>, by channel name. If <channels> is omitted, all users are shown, grouped by channel name with all users who are not on a channel being shown as part of channel "*".

###NICK
Syntax:  ```NICK <nickname>```

> Allows a client to change their IRC nickname.

###NOTICE
Syntax:  ```NOTICE <msgtarget> <message>```

> This command works similarly to PRIVMSG, except automatic replies must never be sent in reply to NOTICE messages.

###OPER
Syntax:  ```OPER <username> <password>```

> Authenticates a user as an IRC operator on the current server.

###PART
Syntax:  ```PART <channels> [<message>]```

> Causes a user to leave the channels in the comma-separated list <channels>.

###PASS
Syntax:  ```PASS <password>```

> Sets a connection password. This command must be sent before the NICK/USER registration combination.

###PING
Syntax:  ```PING <server>```

> Tests the presence of a connection. A PING message results in a PONG reply.

###PONG
Syntax:  ```PONG <server>```

> This command is a reply to the PING command and works in much the same way.

###PRIVMSG
Syntax:  ```PRIVMSG <msgtarget> <message>```

> Sends <message> to <msgtarget>, which is usually a user or channel.

###QUIT
Syntax:  ```QUIT [<message>]```

> Disconnects the user from the server.

###REHASH
Syntax:  ```REHASH```

> Causes the server to re-read and re-process its configuration file(s). This command can only be sent by IRC Operators.

###RESTART
Syntax:  ```RESTART```

> Restarts a server. It may only be sent by IRC Operators.

###STATS
Syntax:  ```STATS <query>```

> Returns statistics about the current server.

###TIME
Syntax:  ```TIME```

> Returns the local time on the current server.

###TOPIC
Syntax:  ```TOPIC <channel> [<topic>]```

> Allows the client to query or set the channel topic on <channel>. If <topic> is given, it sets the channel topic to <topic>. If channel mode +t is set, only a channel operator may set the topic.

###USER
Syntax:  ```USER <user> <mode> <unused> <realname>```

> This command is used at the beginning of a connection to specify the username, hostname, real name and initial user modes of the connecting client. <realname> may contain spaces, and thus must be prefixed with a colon.

###VERSION
Syntax:  ```VERSION```

> Returns the version of the current server.

###WALLOPS
Syntax:  ```WALLOPS <message>```

> Sends <message> to all operators connected to the server, or all users with user mode 'w' set.

###WHO
Syntax:  ```WHO <name>```

> Returns a list of users who match <name>.

###WHOIS
Syntax:  ```WHOIS <nicknames>```

> Returns information about the comma-separated list of nicknames masks <nicknames>.

###WHOWAS
Syntax:  ```WHOWAS <nickname>```

> Used to return information about a nickname that is no longer in use (due to client disconnection, or nickname changes).