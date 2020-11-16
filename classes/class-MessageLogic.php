<?php

namespace TweetBot;

class MessageLogic
{
	/**
	 * Message logic
	 *
	 * @param array $data
	 * @param string $time
	 * @return string
	 */
	function messageLogic(array $data, string $time)
	{
		$bars     = array('@BLANCOCERRILLO', '#ElTito', '@manolocateca', '#Quitapesares', '#SantaMarta', '#LasGolondrinas', '@AzoteaSevilla', '#CasaRafita', '#ElRinconcillo', '#CasaDiego', '@CasaRicardoSev', '#CasaRuperto', '#DosDeMayo', '@EspacioEslava', '@Le_XIX');
		$keyBar    = array_rand($bars, 1);
		$bar       = $bars[$keyBar];


		if ($time === 'morning') {
			$moment  = 'Esta mañana';
			$actions = array('échate en el sofá', 'quéate viendo Netflix', 'quéate viendo "Hoy en día"', 'quéate trabajando');
		} elseif ($time === 'noon') {
			$moment = 'Esta tarde';
			$actions = array('quéate en casa viendo "Andalucía Directo"', 'échate la siesta', 'date un paseo por Triana', 'pasea por la Macarena', 'vete al Alamillo');
		} elseif ($time === 'afternoon') {
			$moment  = 'Ya hoy no te da lugar. Mañana';
			$actions = array('vete a La Alameda a tomarte argo', 've con los niños al parque', 'haz algo de provecho y baja la basura', 'saca al perro que se mueve menos que los ojos de Espinete');
		}

		$keyActions = array_rand($actions, 1);
		$action     = $actions[$keyActions];

		// Sometimes $data['skyStateDes'] is empty
		$skyStateDes = (!empty($data['skyStateDes'])) ? $data['skyStateDes'] : 'despejado';

		if ($data['chancePrecipitation'] > 85) {
			$tweetContent = $moment . ' el cielo estará ' . $skyStateDes . '. Mejón ' . $action . ' que poner la lavadora.';
		} else {

			if ($data['windSpeed'] != 0) {
				if (0 < $data['windSpeed'] && $data['windSpeed'] < 10) {
					$windSpeeds = array('no hacen falta pinzas.', 'como un soplío de flojo.', 'con muy poca fuerza.');
				} elseif (10 < $data['windSpeed'] && $data['windSpeed'] < 20) {
					$windSpeeds = array('flojito, pero ponle pinzas.', 'con poca fuerza.');
				} elseif ($data['windSpeed'] > 20) {
					$windSpeeds = array('fuertecito, pon pinzas de las güenas.', 'con cohone.', 'con mucha fuerza.');
				}
				$keyWindSpeed = array_rand($windSpeeds, 1);
				$windSpeed    = $windSpeeds[$keyWindSpeed];

				switch ($data['windDir']) {
					case 'S':
						$windDir = 'Cádiz (huele a chicharrones)';
						break;

					case 'SO':
						$windDir = 'Matalascañas (olor a playa)';
						break;

					case 'O':
						$windDir = 'Huelva (olor a gambas)';
						break;

					case 'NO':
						$windDir = 'Aznalcollar (sin premio)';
						break;

					case 'N':
						$windDir = 'Sierra Norte (refresca)';
						break;

					case 'NE':
						$windDir = 'La Algaba';
						break;

					case 'E':
						$windDir = 'Sevilla Este (donde da la vuelta)';
						break;

					case 'SE':
						$windDir = 'Montequinto';
						break;

					default:
						$windDir = $data['windDir'];
						break;
				}
				$wind = 'Viento de ' . $windDir . ' y ' . $windSpeed;
			} else {
				$winds    = array('No hacen falta pinzas porque el aire estará más calmao que en la boda de la Infanta.', 'El aire se va a mover menos que los ojos de Espinete', 'Va a soplar menos aire que en el lavabo de una discoteca');
				$keyWinds = array_rand($winds, 1);
				$wind     = $winds[$keyWinds];
			}


			if ($data['relativeHumidity'] < 50) {
				$RHs = array('El aire tiene meno humedá que una mojama.', 'Aire seco como el pellejo de la abuela.', 'Aire seco como un salero', 'Aire más seco que el ojo Benito');
			} elseif (50 < $data['relativeHumidity'] && $data['relativeHumidity'] < 85) {
				$RHs = array('Vamo a tené una humedá normal.');
			} else {
				$RHs = array('Si ve que se te encrespa er pelo es porque va ha haber humedá.', 'Aire con más humedá que el sótano de los Soprano.', 'Humedá pa reventá: lo mismo tarda en secarse.', 'Aire con más humedá que las caras de Belmez');
			}
			$keyRHs = array_rand($RHs, 1);
			$RH     = $RHs[$keyRHs];


			if ($data['temperature'] < 15) {
				$temperatures = array('Va a tardar en secarse porque no hace mucha caló.', 'Va a refrescar. ¿Pa qué va a tender?');
			} elseif (15 < $data['temperature'] && $data['temperature'] < 30) {
				$temperatures = array('Va\'stá pa irse a ' . $bar . ' después de tender.', 'Yo me iba a ' . $bar . ' después de tender.', 'Te espero en ' . $bar . ' cuando termines de tender.', 'Cuantito termines de tender vete a ' . $bar . '.');
			} else {
				$temperatures = array('Con esta caló lo mismo se te quea acartoná.', 'No dejes la ropa al sol directo', 'Más caló que corré con er capirote del gran Poder');
				$RH = '';
			}
			$keyTemperatures = array_rand($temperatures, 1);
			$temperature     = $temperatures[$keyTemperatures];

			$tweetContent = $moment . ' estará ' . $skyStateDes . '. ' . $wind . ' ' . $temperature . ' ' . $RH;
		}
		return $tweetContent;
	}
}
