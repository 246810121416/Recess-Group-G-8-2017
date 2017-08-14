#include<stdio.h>
#include<string.h>
#include<sys/types.h>
#include<sys/socket.h>
#include<netinet/in.h>
#include<stdlib.h>
#include<netdb.h>
void error(char *msg)
{
perror(msg);
exit(1);
}

int main(int argc,char *argv[]){

int sockfd,newsockfd,portno,clilen;
struct sockaddr_in serv_addr,cli_addr;
struct hostent *server;
 
 listen(sockfd,5);
   clilen = sizeof(cli_addr);

	char *a[256];
	char message[256];
   char reply[256];
   char client[256];
   char password[256];
   char logins[256];
  
   char statement[256];
   char state[256];


portno =6600;
   
   /* Create a socket point */
   sockfd = socket(AF_INET, SOCK_STREAM, 0);
   
   if (sockfd < 0)
   {
      perror("ERROR opening socket");
      exit(1);
   }
   server = gethostbyname(argv[1]);
   
   if (server == NULL) {
      fprintf(stderr,"ERROR, no such host\n");
      exit(0);
   }
   
   bzero((char *) &serv_addr, sizeof(serv_addr));
   serv_addr.sin_family = AF_INET;
   bcopy((char *)server->h_addr,(char *)&serv_addr.sin_addr.s_addr,server->h_length);
   serv_addr.sin_port = htons(portno);
   
   /* Now connect to the server */
   if (connect(sockfd,&serv_addr,sizeof(serv_addr)) < 0)
   {
      perror("ERROR connecting");
      exit(1);
   }
   
	
	printf("Username> ");//entering username for client
	scanf("%s",client);
   write(sockfd,client,strlen(client));
   printf("Password> ");//entering password for client
	scanf("%s",password);
   write(sockfd,password,strlen(password));
  
   bzero(logins,256);
   read(sockfd,logins,255);
   if(logins>0) {
  		 puts(logins);
  		 
  		 printf("\n\n Write the commands to be input in the format below:\n");
			printf("-------------------------------------------------------------\n");
			printf(" contribution amount date member_id receipt_number\n");
			printf(" loan_request amount memberID\n");
			printf(" idea name capital simple_description memberID\n");
			printf(" loan_repayment date amount memberID\n");
			printf("-------------------------------------------------------------\n");
			
			write(1,"Command:",9);
			read(0,a,100);
			printf("%s\n",a);
			write(sockfd,a,strlen(a));
   			
			
   	}
   	
 

//return 0;
}
