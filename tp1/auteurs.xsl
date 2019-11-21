<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="bibliotheque.css"?>
<!--Auteurs :
 Mourad Benchikh 20034241 
 Lenny Siemeni    1055234 -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema" exclude-result-prefixes="xs" version="2.0">
    <xsl:template match="/bibliotheque">
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                <title>Bibliotheque</title>
                <link rel="stylesheet" type="text/css" href="bibliotheque.css"/>
            </head>
            <body class="corps">
                <h1 align="center" style="background-color:coral"> Listing des auteurs </h1>
                <table class="tab">   
                    <xsl:for-each select="//auteur">
                        <tr>
                            <td>
                                <h3>Auteur</h3>
                                <ul>
                                    <li><span class="text"><xsl:text> Nom: </xsl:text></span><xsl:value-of select="nom"/>
                                </li>

                                    <li><span class="text"><xsl:text> Prenom: </xsl:text></span><xsl:value-of select="prenom"/>
                                </li>

                                    <li><span class="text"><xsl:text> Pays: </xsl:text></span><xsl:value-of select="pays"/></li>
                                </ul>
                                <!-- Verifie si l'element possede un commentaire puisque optionnel -->
                                <xsl:if test="commentaire">
                                    <h3>Commentaire :</h3>
                                    <p class="comment"><xsl:value-of select="commentaire"/></p>
                                </xsl:if>
                                <img style="width:250px">
                                    <xsl:attribute name="src">
                                        <xsl:value-of select="photo/@url"/>
                                    </xsl:attribute>
                                </img>
                            </td>
                            <td class="colonne2" colspan="2">
                                <h3> Livres </h3>
                                <ul>    
                                    <xsl:call-template name="book">
                                    <xsl:with-param name="livre_spec" select="@ident"/>
                                    </xsl:call-template>
                                </ul>
                            </td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
    <xsl:template name="book">
        <xsl:param name="livre_spec"/>
        <xsl:for-each select="//livre">
            <xsl:sort select="prix" order="descending" data-type="number" />   
            <!-- On match le prix du livre avec l'auteur(s) correspondant. Permet de ne pas cree de doublons dans la liste -->
            <xsl:if test="contains(@auteurs, $livre_spec)">
                <li><span class="text"><xsl:text> Titre: </xsl:text></span><xsl:value-of select="titre"/></li>
                
                <li><span class="text"><xsl:text> Langue: </xsl:text></span><xsl:value-of select="@langue"/></li>
                
                <li><span class="text"><xsl:text>  Prix: </xsl:text></span>
                    <xsl:value-of select="prix"/><xsl:text> </xsl:text><xsl:value-of select="prix/@devise"/></li>
            </xsl:if>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>
