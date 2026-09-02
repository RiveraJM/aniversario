<?php
require_once __DIR__ . '/../vendor/autoload.php';

class GoogleSheets {
    private $client;
    private $service;
    private $spreadsheetId;
    private $credentialsPath;
    
    /**
     * Constructor - Inicializa la conexión con Google Sheets
     */
    public function __construct() {
        // Ruta al archivo JSON de credenciales
        $this->credentialsPath = dirname(__DIR__) . '/config/google-credentials.json';
        
        // ID de la hoja de cálculo
        $this->spreadsheetId = '1SPIqTQW0Cls1346iKCz4CBzyAAJyd1beItPVbzU02xE';

        // Extraer ID si se pasa una URL completa
        if (preg_match('/\/d\/([A-Za-z0-9-_]+)/', 'https://docs.google.com/spreadsheets/d/1SPIqTQW0Cls1346iKCz4CBzyAAJyd1beItPVbzU02xE/edit?gid=154884528#gid=154884528', $matches)) {
            $this->spreadsheetId = $matches[1];
        }

        if (!file_exists($this->credentialsPath)) {
            error_log('Google Sheets: no se encontró el archivo de credenciales en ' . $this->credentialsPath);
            $this->client = null;
            $this->service = null;
            return;
        }
        
        // Inicializar cliente
        $this->client = new Google\Client();
        $this->client->setApplicationName('Registro Aniversario');
        $this->client->setScopes([Google\Service\Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig($this->credentialsPath);
        $this->client->setAccessType('offline');
        
        $this->service = new Google\Service\Sheets($this->client);
    }

    /**
     * Verifica que Google Sheets esté listo para usar
     */
    private function isReady() {
        return $this->service instanceof Google\Service\Sheets;
    }
    
    /**
     * Escapa el nombre de la hoja para usarlo en rangos
     */
    private function quoteSheetName($nombreHoja) {
        return preg_match('/^[A-Za-z0-9_]+$/', $nombreHoja) ? $nombreHoja : "'" . str_replace("'", "''", $nombreHoja) . "'";
    }

    /**
     * Genera un código único de registro
     */
    private function generarCodigo() {
        return 'REG-' . strtoupper(substr(md5(uniqid()), 0, 8));
    }

    /**
     * Obtiene el próximo ID disponible en una hoja específica
     */
    private function getNextId($nombreHoja) {
        try {
            $range = $this->quoteSheetName($nombreHoja) . '!A:A';
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();
            
            if (empty($values) || count($values) <= 1) {
                return 1;
            }
            
            return count($values);
            
        } catch (Exception $e) {
            error_log('Error al obtener ID: ' . $e->getMessage());
            return time();
        }
    }

    // ========================================
    // 1. CADE EDUCATIVO (Individual)
    // Columnas: A-J
    // ========================================
    public function guardarRegistroCade($datos) {
        if (!$this->isReady()) {
            error_log('Google Sheets no está configurado');
            return false;
        }

        try {
            $nombreHoja = 'CADE Educativo';
            
            $values = [[
                $datos['id'] ?? $this->getNextId($nombreHoja),
                $datos['fecha'] ?? date('d/m/Y H:i:s'),
                $datos['nombres'] ?? '',
                $datos['apellidos'] ?? '',
                $datos['dni'] ?? '',
                $datos['cargo'] ?? '',
                $datos['email'] ?? '',
                $datos['telefono'] ?? '',
                $datos['institucion'] ?? '',
                $datos['codigo'] ?? $this->generarCodigo()
            ]];
            
            $range = $this->quoteSheetName($nombreHoja) . '!A:J';
            $body = new Google\Service\Sheets\ValueRange(['values' => $values]);
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, ['valueInputOption' => 'USER_ENTERED']);
            return true;
            
        } catch (Exception $e) {
            error_log('Error CADE: ' . $e->getMessage());
            return false;
        }
    }

    // ========================================
    // 2. SESIÓN SOLEMNE (Institucional)
    // Columnas: A-J
    // ========================================
    public function guardarRegistroSesionSolemne($datos) {
        if (!$this->isReady()) {
            error_log('Google Sheets no está configurado');
            return false;
        }

        try {
            $nombreHoja = 'Sesión Solemne';
            
            $values = [[
                $datos['id'] ?? $this->getNextId($nombreHoja),
                $datos['fecha'] ?? date('d/m/Y H:i:s'),
                $datos['institucion'] ?? '',
                $datos['representante'] ?? '',
                $datos['cargo'] ?? '',
                $datos['participantes'] ?? 1,
                $datos['cargo_participantes'] ?? '',
                $datos['email'] ?? '',
                $datos['telefono'] ?? '',
                $datos['codigo'] ?? $this->generarCodigo()
            ]];
            
            $range = $this->quoteSheetName($nombreHoja) . '!A:J';
            $body = new Google\Service\Sheets\ValueRange(['values' => $values]);
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, ['valueInputOption' => 'USER_ENTERED']);
            return true;
            
        } catch (Exception $e) {
            error_log('Error Sesión Solemne: ' . $e->getMessage());
            return false;
        }
    }

    // ========================================
    // 3. DESFILE PLAZA TARAPOTO (Institucional)
    // Columnas: A-H
    // ========================================
    public function guardarRegistroDesfile($datos) {
        if (!$this->isReady()) {
            error_log('Google Sheets no está configurado');
            return false;
        }

        try {
            $nombreHoja = 'Desfile Plaza Tarapoto';
            
            $values = [[
                $datos['id'] ?? $this->getNextId($nombreHoja),
                $datos['fecha'] ?? date('d/m/Y H:i:s'),
                $datos['nombre_delegacion'] ?? $datos['nombre_equipo'] ?? '',
                $datos['nombre_contacto'] ?? $datos['representante'] ?? '',
                $datos['telefono'] ?? '',
                $datos['email'] ?? '',
                $datos['participantes'] ?? 1,
                $datos['codigo'] ?? $this->generarCodigo()
            ]];
            
            $range = $this->quoteSheetName($nombreHoja) . '!A:H';
            $body = new Google\Service\Sheets\ValueRange(['values' => $values]);
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, ['valueInputOption' => 'USER_ENTERED']);
            return true;
            
        } catch (Exception $e) {
            error_log('Error Desfile: ' . $e->getMessage());
            return false;
        }
    }

    // ========================================
    // 4. DEPORTE INTERINSTITUCIONES (Institucional)
    // Columnas: A-H
    // ========================================
    public function guardarRegistroDeporteInterinstituciones($datos) {
        if (!$this->isReady()) {
            error_log('Google Sheets no está configurado');
            return false;
        }

        try {
            $nombreHoja = 'Deporte Interinstituciones';
            
            $values = [[
                $datos['id'] ?? $this->getNextId($nombreHoja),
                $datos['fecha'] ?? date('d/m/Y H:i:s'),
                $datos['institucion'] ?? '',
                $datos['nombre_equipo'] ?? $datos['equipo'] ?? '',
                $datos['disciplinas'] ?? '',
                $datos['telefono'] ?? '',
                $datos['email'] ?? '',
                $datos['codigo'] ?? $this->generarCodigo()
            ]];
            
            $range = $this->quoteSheetName($nombreHoja) . '!A:H';
            $body = new Google\Service\Sheets\ValueRange(['values' => $values]);
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, ['valueInputOption' => 'USER_ENTERED']);
            return true;
            
        } catch (Exception $e) {
            error_log('Error Deporte Interinstituciones: ' . $e->getMessage());
            return false;
        }
    }

    // ========================================
    // 5. CONCURSO ALZARÉ MI VOZ (Institucional)
    // Columnas: A-I
    // ========================================
    public function guardarRegistroAlzareMiVoz($datos) {
        if (!$this->isReady()) {
            error_log('Google Sheets no está configurado');
            return false;
        }

        try {
            $nombreHoja = 'Concurso Alzaré mi Voz';
            
            $values = [[
                $datos['id'] ?? $this->getNextId($nombreHoja),
                $datos['fecha'] ?? date('d/m/Y H:i:s'),
                $datos['institucion'] ?? '',
                $datos['ciudad'] ?? '',
                $datos['nombre_equipo'] ?? $datos['nombre_artistico'] ?? '',
                $datos['nombre_contacto'] ?? '',
                $datos['telefono'] ?? '',
                $datos['email'] ?? '',
                $datos['codigo'] ?? $this->generarCodigo()
            ]];
            
            $range = $this->quoteSheetName($nombreHoja) . '!A:I';
            $body = new Google\Service\Sheets\ValueRange(['values' => $values]);
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, ['valueInputOption' => 'USER_ENTERED']);
            return true;
            
        } catch (Exception $e) {
            error_log('Error Alzaré mi Voz: ' . $e->getMessage());
            return false;
        }
    }

    // ========================================
    // 6. DEPORTE INTERIGLESIAS (Institucional)
    // Columnas: A-H
    // ========================================
    public function guardarRegistroInterIglesias($datos) {
        if (!$this->isReady()) {
            error_log('Google Sheets no está configurado');
            return false;
        }

        try {
            $nombreHoja = 'Deporte InterIglesias';
            
            $values = [[
                $datos['id'] ?? $this->getNextId($nombreHoja),
                $datos['fecha'] ?? date('d/m/Y H:i:s'),
                $datos['institucion'] ?? '',
                $datos['nombre_equipo'] ?? $datos['equipo'] ?? '',
                $datos['disciplinas'] ?? '',
                $datos['telefono'] ?? '',
                $datos['email'] ?? '',
                $datos['codigo'] ?? $this->generarCodigo()
            ]];
            
            $range = $this->quoteSheetName($nombreHoja) . '!A:H';
            $body = new Google\Service\Sheets\ValueRange(['values' => $values]);
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, ['valueInputOption' => 'USER_ENTERED']);
            return true;
            
        } catch (Exception $e) {
            error_log('Error InterIglesias: ' . $e->getMessage());
            return false;
        }
    }

    // ========================================
    // MÉTODOS ADICIONALES
    // ========================================
    
    /**
     * Verifica si la conexión con Google Sheets es exitosa
     */
    public function testConnection() {
        try {
            $this->service->spreadsheets_values->get($this->spreadsheetId, 'Hoja1!A1:A1');
            return true;
        } catch (Exception $e) {
            error_log('Error de conexión: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todos los registros de una hoja específica
     */
    public function obtenerRegistros($nombreHoja = 'Hoja1') {
        try {
            $range = $this->quoteSheetName($nombreHoja) . '!A:Z';
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();
            
            if (empty($values)) {
                return [];
            }
            
            $headers = array_shift($values);
            $registros = [];
            
            foreach ($values as $row) {
                $registro = [];
                foreach ($headers as $index => $header) {
                    $registro[$header] = $row[$index] ?? '';
                }
                $registros[] = $registro;
            }
            
            return $registros;
            
        } catch (Exception $e) {
            error_log('Error al obtener registros: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene el total de registros en una hoja específica
     */
    public function contarRegistros($nombreHoja = 'Hoja1') {
        return count($this->obtenerRegistros($nombreHoja));
    }

    // ========================================
    // MÉTODO GENÉRICO (Respaldo)
    // ========================================
    public function guardarRegistro($datos, $nombreHoja = 'Hoja1') {
        if (!$this->isReady()) {
            error_log('Google Sheets no está configurado');
            return false;
        }

        try {
            $values = [[
                $datos['id'] ?? $this->getNextId($nombreHoja),
                $datos['fecha'] ?? date('d/m/Y H:i:s'),
                $datos['institucion'] ?? '',
                $datos['tipo_institucion'] ?? '',
                $datos['direccion'] ?? '',
                $datos['telefono_institucion'] ?? '',
                $datos['email_institucion'] ?? '',
                $datos['representante'] ?? '',
                $datos['cargo'] ?? '',
                $datos['representante_dni'] ?? '',
                $datos['representante_telefono'] ?? '',
                $datos['representante_email'] ?? '',
                $datos['participantes'] ?? 1,
                $datos['codigo'] ?? $this->generarCodigo()
            ]];
            
            $range = $this->quoteSheetName($nombreHoja) . '!A:N';
            $body = new Google\Service\Sheets\ValueRange(['values' => $values]);
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, ['valueInputOption' => 'USER_ENTERED']);
            return true;
            
        } catch (Exception $e) {
            error_log('Error genérico: ' . $e->getMessage());
            return false;
        }
    }
}
?>