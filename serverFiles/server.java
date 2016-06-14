package alebian;
import alebian.messageHandler;
import alebian.PHPInterpreter;
import java.io.*;
import java.net.*;

public class server{
	public static void main(String args[]){
		try{
			for(int i=0;i<6;i++)args[i].charAt(0);
		}catch(Exception e){
			System.out.println("\u001B[31m[ERROR]: \u001B[0m"+"Usage: server [domain_name][token][port][site_folder][site_index][DEV][DDNS]");
			System.exit(1);
		}
		if(args[6].equals("true")){
			System.out.println("\u001B[31m[SERVER]: \u001B[0m"+"Starting DDNS");
			try{
				URL url = new URL("https://duckdns.org/update/"+args[0]+"/"+args[1]);
				String l = new BufferedReader(new InputStreamReader(url.openStream())).readLine();
				if(!l.equals("OK")){System.out.println("\u001B[31m[DDNS]: \u001B[0m"+"Connection error, check the token");System.exit(1);}
			}catch(Exception e){e.printStackTrace();}
		}

		ServerSocket sSocket;
		Socket s = null;
		int port = Integer.parseInt(args[2]);
		try{
			sSocket = new ServerSocket(port);
			System.out.println("\u001B[31m[SERVER]: \u001B[0m"+"Server <"+args[0]+"> started");
			while(true){
				s = sSocket.accept();
				new serverThread(s,args[3],args[4],args[5]);
			}
		}
		catch(Exception e){
			System.out.println("\u001B[31m[ERROR]: \u001B[0m"+e);
		}
	}
}

class serverThread implements Runnable {

	String sitePath = null;
	String index = null;

	private Socket s = null;
	PrintWriter pw;
	messageHandler mh;
	PHPInterpreter PHP;

	public serverThread(Socket c,String sitePath,String index,String dev) throws Exception{
	this.sitePath = sitePath;
	this.index = index;
		s = c;
		Thread t = new Thread(this);
		pw = new PrintWriter(s.getOutputStream());
		mh = new messageHandler(s.getInputStream());
		t.start();
		PHP = new PHPInterpreter(dev.equals("true") ? true : false);
	}

	public void run(){
		try {
			while (true) {
				mh.handle();
				mh.Path = mh.Path.equals("/") ? index : mh.Path;
				DELIVER();
				if (mh.Connection.equalsIgnoreCase("Close")) return;
			}
		}catch(NullPointerException e){
			try{
				pw.close();
				s.close();
			}catch (Exception e1){}
			return;
		}catch(FileNotFoundException e){
			print("\u001B[31m"+e.getMessage()+"\u001B[0m");
			send("HTTP/1.1 404 File Not Found");
			send("");
		}catch(Exception e){
			print("\u001B[31m"+e+"\u001B[0m");
			try{
				pw.close();
				s.close();
			}catch (Exception e1){}
			return;
		}
	}

//	SERVER METHODS
	private void print(String s){
		System.out.println("[ISSUE]: "+s);
	}
	private void send(String x){
		pw.println(x);pw.flush();
	}
	private void DELIVER() throws Exception {
		byte[] buffer = new byte[1024];
		int bytesRead;
		String session_ID = PHPInterpreter.randomUUID();

		send("HTTP/1.1 200 OK");
		if(mh.Cookie == null){
			send("Set-Cookie: session_ID="+session_ID);
			mh.Cookie = "session_ID="+session_ID;
		}

		String name = sitePath+mh.Path;
		File x = name.endsWith(".php") ? PHP.eval(name,mh.Parameters,mh.body,mh.Cookie) : new File(name);
		FileInputStream file = new FileInputStream(x);
		DataOutputStream send = new DataOutputStream(s.getOutputStream());

		send("Content-Length: "+x.length());
		send("");

		while ((bytesRead = file.read(buffer)) != -1)
			send.write(buffer, 0, bytesRead);

		send("");
		send.flush();
		file.close();
	}
}
