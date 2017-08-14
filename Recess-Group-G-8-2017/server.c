#include<stdio.h>
#include<stdlib.h>
#include<sys/types.h>
#include<sys/socket.h>
#include<netinet/in.h>
#include<mysql/mysql.h>
#include<string.h>
#include<assert.h>


void error(char *msg)
{
perror(msg);
exit(1);
}
int main( int argc, char *argv[] )
{
   int sockfd, newsockfd, portno, clilen;
   struct sockaddr_in serv_addr, cli_addr;
   int  pid;
   char me;
   
   /* First call to socket() function */
   sockfd = socket(AF_INET, SOCK_STREAM, 0);
   
   if (sockfd < 0)
      {
      perror("ERROR opening socket");
      exit(1);
      }
   
   /* Initialize socket structure */
   bzero((char *) &serv_addr, sizeof(serv_addr));
   portno = 6600;
   
   serv_addr.sin_family = AF_INET;
   serv_addr.sin_addr.s_addr = INADDR_ANY;
   serv_addr.sin_port = htons(portno);
   
   /* Now bind the host address using bind() call.*/
   if (bind(sockfd, (struct sockaddr *) &serv_addr, sizeof(serv_addr)) < 0)
      {
      perror("ERROR on binding");
      exit(1);
      }
   
   /* Now start listening for the clients, here
   * process will go in sleep mode and will wait
   * for the incoming connection
   */
   
   listen(sockfd,5);
   clilen = sizeof(cli_addr);
   
   while (1)
   {
      newsockfd = accept(sockfd, (struct sockaddr *) &cli_addr, &clilen);
      if (newsockfd < 0)
         {
         perror("ERROR on accept");
         exit(1);
         }
      
      /* Create child process */
      pid = fork();
      if (pid < 0)
         {
         perror("ERROR on fork");
         exit(1);
         }
      
      if (pid == 0)
         {
         /* This is the client process */
        // close(sockfd);
         result(newsockfd);
        
         }
      else
         {
         close(newsockfd);
         }
   } /* end of while */
}


void result (int sock)
{
	static char *host="localhost";
	static char *user="root";
	static char *pass="saazi";
	static char *dbname="recess";
	unsigned int port=3306;
	static char *unix_socket=NULL;
	unsigned int flag=0;	
	
 	MYSQL *conn;
	MYSQL_RES *res;
   MYSQL_ROW row;
	mysql_init(conn);	
	
	char app[256];
	char ap[256];
	char me;
	char *n;
	char reply[256];
	char message[256];
	char *username[256];
	char *password[256];
	char statement[256];
	char memberid;
	int i = 0;
  
	FILE *fptr;
	
	
	MYSQL mysql;
	char *query;
	char *q;
   
	mysql_init(&mysql);
	
	


	
	char fname[20] = "recess.txt";
	fptr = fopen(fname,"a");
	
	
		
		
	bzero(username,256);
	read(sock,username,255);
	
	bzero(password,256);
	read(sock,password,255);
	

	snprintf(statement, 256, "SELECT * FROM member WHERE username ='%s'",username);
	puts(statement);
	
	
	if(!mysql_real_connect(&mysql,"localhost","root","saazi","recess",0,NULL,0))
	{

			
			 mysql_close(&mysql);
			 exit(0);
	}

	if(mysql_query(&mysql,statement))
	{

		
			 mysql_close(&mysql);
			 exit(0);
	}
	
	
	MYSQL_RES *result;
	result = mysql_use_result(&mysql);

	if (result)  
	{
		
		MYSQL_ROW row;
		while((row = mysql_fetch_row(result)))
		{
			unsigned long *lengths = mysql_fetch_lengths(result);
			if(lengths[0] > 0)
			{
				
				q=row[0];
			
				send(sock,q,45,0);
		
				
			
			}
			
		
		}
		mysql_free_result(result);
	}


			
	
			bzero(app,256);
			read(sock,app,255);
			puts(app);
			
			fptr = fopen("recess.txt","a");
			fputs(app,fptr);
			fclose( fptr );
			
			
	
return 0;
}
