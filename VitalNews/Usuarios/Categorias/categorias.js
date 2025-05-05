import { Facebook, Mail } from "lucide-react";
import { motion } from "framer-motion";

export default function Footer() {
  return (
    <footer className="bg-gray-900 text-white shadow-lg">
      <div className="container mx-auto py-8 px-4 flex flex-col md:flex-row justify-between items-center">
        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 1 }}
          className="mb-4 md:mb-0"
        >
          <h2 className="text-xl font-bold">Síguenos en nuestras redes</h2>
        </motion.div>
        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 1.2 }}
          className="flex space-x-6"
        >
          {/* Facebook */}
          <a
            href="https://www.facebook.com/share/1DsxG3er3o/"
            target="_blank"
            rel="noopener noreferrer"
            className="text-blue-600 hover:text-blue-800 transition transform hover:scale-110 shadow-md p-2 rounded-full bg-white"
          >
            <Facebook size={24} />
          </a>
          
          {/* Gmail */}
          <a
            href="mailto:vitals.news.pi@gmail.com?subject=Contacto%20desde%20la%20web&body=Hola%2C%20quiero%20ponerme%20en%20contacto%20contigo."
            className="text-red-600 hover:text-red-800 transition transform hover:scale-110 shadow-md p-2 rounded-full bg-white"
          >
            <Mail size={24} />
          </a>
        </motion.div>
      </div>
      <div className="text-center text-gray-400 text-sm py-4">
        © 2025 Tu Empresa. Todos los derechos reservados.
      </div>
    </footer>
  );
}