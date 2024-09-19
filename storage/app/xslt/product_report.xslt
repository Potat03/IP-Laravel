<?xml version="1.0" encoding="UTF-8"?>
<!--
    Author: Lim Weng Ni
    Date: 20/09/2024
-->

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
        <h2>Monthly Product Report</h2>

        <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price (RM)</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Total Sold</th>
                    <th>Recommended Restock Quantity</th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="report/products/product">
                    <tr>
                        <td><xsl:value-of select="id"/></td>
                        <td><xsl:value-of select="name"/></td>
                        <td><xsl:value-of select="type"/></td>
                        <td><xsl:value-of select="price"/></td>
                        <td><xsl:value-of select="stock"/></td>
                        <td><xsl:value-of select="status"/></td>
                        <td><xsl:value-of select="total_sold"/></td>
                        <td><xsl:value-of select="restock_recommendation"/></td>
                    </tr>
                </xsl:for-each>
            </tbody>
        </table>
        <h4 style="font-size: 1.5em; font-weight: bold; color: #333; margin-top: 20px;">Summary</h4>
        <p style="font-size: 1.2em; color: #555; margin-bottom: 10px;">
            Total Inventory Value: 
            <span style="font-weight: bold; color: #000;">RM <xsl:value-of select="/report/total_value"/></span>
        </p>
        <p style="font-size: 1.2em; color: #555;">
            Inventory Turnover Rate: 
            <span style="font-weight: bold; color: #000;"><xsl:value-of select="/report/inventory_turnover_rate"/></span>
        </p>
    </xsl:template>
</xsl:stylesheet>
