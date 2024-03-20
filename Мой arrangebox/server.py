from http.server import HTTPServer, BaseHTTPRequestHandler
import os

# Получаем текущую директорию, в которой находится этот скрипт
current_dir = os.path.dirname(os.path.abspath(__file__))

class SimpleHTTPRequestHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        if self.path == '/':
            filename = os.path.join(current_dir, 'index.html')
        else:
            filename = os.path.join(current_dir, self.path[1:])  # Удаляем первый символ (/) из пути
        try:
            with open(filename, 'rb') as f:
                content = f.read()
                self.send_response(200)
                if filename.endswith('.html'):
                    self.send_header('Content-type', 'text/html')
                elif filename.endswith('.css'):
                    self.send_header('Content-type', 'text/css')
                elif filename.endswith('.js'):
                    self.send_header('Content-type', 'application/javascript')
                self.end_headers()
                self.wfile.write(content)
        except FileNotFoundError:
            self.send_error(404, 'File not found')

# Функция run() и дальнейший код остаются без изменений
def run(server_class=HTTPServer, handler_class=SimpleHTTPRequestHandler, port=8000):
    server_address = ('', port)
    httpd = server_class(server_address, handler_class)
    print(f'Server started on port {port}')
    httpd.serve_forever()

if __name__ == '__main__':
    run()
